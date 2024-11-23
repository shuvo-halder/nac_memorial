<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SuccessMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;

class PopupMessageController extends Controller
{
    public function index()
    {
        $keys = SuccessMessage::paginate(10);

        return view('admin.popup_message.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Social Links'),
            'settings' => Setting::first(),
            'keys' => $keys
        ]);
    }

    public function edit($id)
    {
        $key = SuccessMessage::findOrFail($id);

        return view('admin.popup_message.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Social Links'),
            'settings' => Setting::first(),
            'key' => $key
        ]);
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        $validation = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        try {
            $key = SuccessMessage::findOrFail($id);

            $key->update([
                'message' => $request->message,
            ]);

            $flasher->addSuccess(__('The message has been updated.'));
            return redirect()->route('admin.popup');
        } catch (\Exception $e) {
            Log::error($e);

            $flasher->addError(__('A problem has been encountered, try again!'));
            return redirect()->back();
        }
    }
}
