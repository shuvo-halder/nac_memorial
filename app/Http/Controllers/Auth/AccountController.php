<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Overtrue\LaravelLike\Traits\Likeable;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\PageTitle;
use App\Models\Admin\Blog\BlogComment;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use Likeable;

    public function index()
    {
        $pageTitle = PageTitle::where('page_identifier', 'account')->first();

        return view('frontend.account.setting')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => __('app.update_your_account_desc'),
            'site_image' => asset('img/avatar/' . Auth::id()) . '/' . Auth::user()->avatar,
            'page_name' => __('app.update_your_account'),
            'pageTitle' => $pageTitle
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Check if the resend verification button was clicked
        if ($request->has('resend_verification') && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            $successMessage = DB::table('success_messages')
                ->where('key', 'verification_sent_success')
                ->value('message');

            $flasher->addInfo($successMessage, 'Success!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return redirect()->back();
        }

        // new password
        if ($request->filled('new_password')) {
            $this->validate($request, [
                'new_password' => 'required|min:8',
                'new_confirm_password' => 'same:new_password',
            ]);

            $update = User::where('id', Auth::id())
                ->update([
                    'password' => bcrypt(request('new_password'))
                ]);

            if ($update) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('login');
            } else {
                return back();
            }
        }

        // avatar
        if ($request->hasfile('avatar')) {
            if (!is_null(Auth::user()->avatar)) {
                File::delete(public_path('img/avatar/' . Auth::id()) . '/' . Auth::user()->avatar);
            }

            $file = $request->file('avatar');
            $name = Str::random(35) . '.' . $file->extension();
            $file->move(public_path('img/avatar/' . Auth::id()), $name);

            // store in db
            $update = Auth::user()->update([
                'avatar' => $name
            ]);
        }

        $update = Auth::user()->update([
            'email' => $request->email,
            'name' => $request->name
        ]);

        if ($update) {
            $flasher->addSuccess(__('app.you_have_updated_your_account'), [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return back();
        } else {
            $flasher->addError(__('app.error_message'), [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);
            return back();
        }
    }

    public function profile($id, $name)
    {
        $pageTitle = PageTitle::where('page_identifier', 'profile')->first();

        $user = User::findOrFail($id);

        $blogComments = BlogComment::where('commented_by', $id)
            ->where('status', 1)
            ->count();

        return view('frontend.account.profile')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => __('app.sd_the_profile_of'),
            'site_image' => asset('img/avatar/' . $user->id) . '/' . $user->avatar,
            'page_name' => __('app.pn_the_profile_of', ['name' => $user->name]),
            'user' => $user,
            'blogComments' => $blogComments,
            'pageTitle' => $pageTitle
        ]);
    }

    public function my_memorial()
    {
        $user = Auth::user();

        $items = Item::where('user_id', $user->id)->latest()->paginate(10);

        return view('frontend.account.my-memorial')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => __('app.sd_the_profile_of'),
            'site_image' => asset('img/avatar/' . $user->id) . '/' . $user->avatar,
            'page_name' => __('app.pn_the_profile_of', ['name' => $user->name]),
            'user' => $user,
            'items' => $items,
        ]);
    }

    public function edit_memorial(Item $item)
    {
        $user = Auth::user();

        return view('frontend.account.edit-memorial')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => __('app.sd_the_profile_of'),
            'site_image' => asset('img/avatar/' . $user->id) . '/' . $user->avatar,
            'page_name' => __('app.pn_the_profile_of', ['name' => $user->name]),
            'user' => $user,
            'item' => $item,
        ]);
    }
}
