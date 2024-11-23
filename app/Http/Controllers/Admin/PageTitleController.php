<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PageTitle;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Log;

class PageTitleController extends Controller
{
    protected $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $pageTitles = PageTitle::paginate(10);

        return view('admin.page_titles.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Page Titles'),
            'settings' => Setting::first(),
            'pageTitles' => $pageTitles
        ]);
    }

    public function edit($id)
    {
        $pageTitle = PageTitle::findOrFail($id);

        return view('admin.page_titles.edit')->with([
            'pageTitle' => $pageTitle,
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Page Title'),
            'settings' => Setting::first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate input fields
        $validation = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
        ]);

        try {
            $pageTitle = PageTitle::findOrFail($id);

            $pageTitle->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ]);


            $this->flasher->success(__('The page title has been updated.'))->flash();
            return redirect()->route('admin.page_titles');
        } catch (\Exception $e) {
            Log::error($e);

            $this->flasher->error(__('A problem has been encountered, try again!'))->flash();
            return redirect()->back();
        }
    }
}
