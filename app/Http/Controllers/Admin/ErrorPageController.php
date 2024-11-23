<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorPage;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ErrorPageController extends Controller
{
    public function index()
    {
        $errorPages = ErrorPage::paginate(5);


        return view('admin.error_page.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Page Titles'),
            'settings' => Setting::first(),
            'errorPages' => $errorPages
        ]);
    }



    public function edit($id)
    {
        $errorPage = ErrorPage::findOrFail($id);

        return view('admin.error_page.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Page Titles'),
            'settings' => Setting::first(),
            'errorPage' => $errorPage
        ]);
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        $request->validate([
            'error_code' => 'required|integer|unique:error_pages,error_code,' . $id,
            'error_title' => 'required|string|max:255',
            'error_message' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $errorPage = ErrorPage::findOrFail($id);
            $errorPage->update([
                'error_code' => $request->input('error_code'),
                'error_title' => $request->input('error_title'),
                'error_message' => $request->input('error_message'),
            ]);

            DB::commit();

            $flasher->addSuccess(__('Error page updaetd successfully.'));

            return redirect()->route('admin.error_page');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', __('An error occurred while updating the error page.'));
        }
    }


}
