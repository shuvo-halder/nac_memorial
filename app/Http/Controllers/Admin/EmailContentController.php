<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailContent;
use App\Models\Setting;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class EmailContentController extends Controller
{
    protected $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    // Display the email content
    public function index()
    {
        $emailContents = EmailContent::paginate(10);

        return view('admin.email_content.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Email Content'),
            'settings' => Setting::first(),
            'emailContents' => $emailContents
        ]);
    }


    public function edit($id)
    {
        $emailContent = EmailContent::where('id', $id)->firstOrFail();

        return view('admin.email_content.edit')->with([
            'emailContent' => $emailContent,
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Email Content'),
            'settings' => Setting::first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'subject' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'footer' => 'nullable|string',
        ]);

        try {
            $emailContent = EmailContent::findOrFail($id);

            $emailContent->update([
                'subject' => $request->subject,
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'content' => $request->content,
                'footer' => $request->footer,
            ]);

            $this->flasher->success(__('The email content has been updated.'))->flash();
            return redirect()->route('admin.email_content');
        } catch (\Exception $e) {
            Log::error($e);

            $this->flasher->error(__('A problem has been encountered, try again!'))->flash();
            return redirect()->back();
        }
    }
}
