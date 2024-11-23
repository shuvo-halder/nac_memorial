<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterDescription;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;

class FooterController extends Controller
{
    // Display a list of footer descriptions
    public function index()
    {
        $footerDescriptions = FooterDescription::all();

        return view('admin.footer.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Footer Descriptions'),
            'settings' => Setting::first(),
            'footerDescriptions' => $footerDescriptions,
        ]);
    }

    public function edit($id)
    {
        $footerDescription = FooterDescription::findOrFail($id);

        return view('admin.footer.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Footer Description'),
            'settings' => Setting::first(),
            'footerDescription' => $footerDescription,
        ]);
    }


    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        // Validate input fields
        $validation = $request->validate([
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        try {
            DB::beginTransaction();


            $footerDescription = FooterDescription::findOrFail($id);

            $footerDescription->update([
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);

            DB::commit();

            $flasher->addSuccess(__('The footer description has been updated.'));
            return redirect()->route('admin.footer');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            $flasher->addError(__('A problem has been encountered, please try again.'));
            return redirect()->back();
        }
    }
}
