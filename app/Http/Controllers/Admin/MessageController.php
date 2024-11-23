<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;

class MessageController extends Controller
{
    // Display a listing of the messages
    public function index()
    {
        $messages = Message::latest()->paginate(10);

        return view('admin.message.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Messages'),
            'settings' => Setting::first(),
            'messages' => $messages,
        ]);
    }

    // Display the specified message
    public function show($id)
    {
        $message = Message::findOrFail($id);

        return view('admin.message.show')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('View Message'),
            'settings' => Setting::first(),
            'message' => $message,
        ]);
    }

    public function destroy($id, FlasherInterface $flasher)
    {
        try {
            $message = Message::findOrFail($id);
            $message->delete();

            $flasher->addSuccess(__('Message deleted successfully.'));

            return redirect()->route('admin.message');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            $flasher->addError(__('An error occurred while trying to delete the message.'));
            return redirect()->back();
        }
    }
}
