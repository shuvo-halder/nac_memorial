<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocialLinkController extends Controller
{
    protected $flasher; // Declare the flasher property

    // Inject FlasherInterface via constructor
    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $socialLinks = SocialLink::all();

        return view('admin.social_links.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Social Links'),
            'settings' => Setting::first(),
            'socialLinks' => $socialLinks
        ]);
    }

    public function create()
    {
        return view('admin.social_links.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create New Post'),
            'settings' => Setting::first(),
        ]);
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'platform' => 'required|string|unique:social_links,platform|max:50',
            'url' => 'required|url|max:255',
            'icon' => 'required|string|max:50'
        ]);

        try {
            DB::beginTransaction();

            $socialLink = SocialLink::create([
                'platform' => $request->platform,
                'url' => $request->url,
                'icon' => $request->icon,
            ]);

            DB::commit();

            $this->flasher->success(__('The social link has been created.'))->flash();
            return redirect()->route("admin.social_links");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            $this->flasher->error(__('A problem has been encountered, try again!'))->flash();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $socialLink = SocialLink::findOrFail($id);

        return view('admin.social_links.edit')->with([
            'socialLink' => $socialLink,
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Social Links Edit'),
            'settings' => Setting::first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'platform' => 'required|string|max:50|unique:social_links,platform,' . $id,
            'url' => 'required|url|max:255',
            'icon' => 'required|string|max:50'
        ]);

        try {
            DB::beginTransaction();
            $socialLink = SocialLink::findOrFail($id);
            $socialLink->update([
                'platform' => $request->platform,
                'url' => $request->url,
                'icon' => $request->icon,
            ]);

            DB::commit();

            $this->flasher->success(__('The social link has been updated.'))->flash();
            return redirect()->route("admin.social_links");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            $this->flasher->error(__('A problem has been encountered, try again!'))->flash();
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $socialLink = SocialLink::findOrFail($id);


            $socialLink->delete();

            DB::commit();


            $this->flasher->success(__('Successfully deleted!'))->flash();
            return redirect()->route('admin.social_links');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);


            $this->flasher->error(__('A problem has been encountered, try again!'))->flash();
            return redirect()->back();
        }
    }
}
