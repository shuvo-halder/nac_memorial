<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Message;
use App\Models\PageTitle;
use App\Models\SuccessMessage;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{

    public function index()
    {

        $pageTitle = PageTitle::where('page_identifier', 'contact')->first();

        return view('frontend.contact.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_description')->value,
            'site_image' => asset('img/logo/logo_big.jpg'),
            'page_name' => Setting::find('app_tagline')->value,
            'pageTitle' => $pageTitle
        ]);
    }

    public function submit(Request $request, FlasherInterface $flasher)
    {
        $ipAddress = $request->ip();
        $cacheKey = 'contact_submission_' . $ipAddress;
        $throttleDuration = 120;

        if (Cache::has($cacheKey)) {

            $successMessage = DB::table('success_messages')
                ->where('key', 'message_send_error')
                ->value('message');


            $flasher->addError($successMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return redirect()->back();
        }

        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'accept_terms' => 'accepted',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        try {
            DB::beginTransaction();

            $message = Message::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            DB::commit();

            Cache::put($cacheKey, true, Carbon::now()->addMinutes($throttleDuration));


            $successMessage = DB::table('success_messages')
                ->where('key', 'message_send_success')
                ->value('message');


            $flasher->addSuccess($successMessage, 'Success!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return redirect()->route('index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('failed', 'A problem has been encountered, please try again!');
        }
    }
}
