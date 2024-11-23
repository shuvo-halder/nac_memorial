<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Setting;
use Alert;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public $new_comments;

    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
        $this->new_comments = Setting::find('new_comments')->value;
    }

    public function store(Request $request, $item_id)
    {
        if (!auth()->user()->hasVerifiedEmail()) {

            $errorAuthMessage = DB::table('success_messages')
                ->where('key', 'user_unverify_comment')
                ->value('message');

            $this->flasher->addInfo($errorAuthMessage, 'Verify Now!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return redirect()->route('account');
        }

        $commentDelay = 60;

        $errorDelayMessage = DB::table('success_messages')
            ->where('key', 'error_delay_comment')
            ->value('message');

        $lastComment = Comment::where('user_id', auth()->id())
            ->where('item_id', $item_id)
            ->latest()
            ->first();

        if ($lastComment && $lastComment->created_at->diffInSeconds(now()) < $commentDelay) {
            $this->flasher->addError($errorDelayMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle',
                'theme' => 'light'
            ]);

            return back();
        }

        if (strlen($request->content) < 5) {
            $errorMinMessage = DB::table('success_messages')
                ->where('key', 'error_min_comment')
                ->value('message');


            $this->flasher->addError($errorMinMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle',
                'theme' => 'light'
            ]);

            return back();
        }


        $validation = $request->validate([
            'content' => 'required|string|max:300'
        ]);

        $successMessage = DB::table('success_messages')
            ->where('key', 'comment_post_success')
            ->value('message');

        $create = Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'status' => $this->new_comments
        ]);

        if ($create) {

            if ($this->new_comments == 1) {
                return back()->with('success', 'Your comment is posted.');
            } else {

                $this->flasher->addInfo($successMessage, 'Success!', [
                    'position' => 'top-center',
                    'timer' => 5000,
                    'icon' => 'check-circle',
                    'theme' => 'light'
                ]);

                return back();
            }
        } else {

            $this->flasher->addError(__('app.error_message'), 'Success!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle'
            ]);

            return back();
        }
    }

    public function loadMore(Request $request, Item $item)
    {
        $offset = $request->get('offset', 0);
        $comments = $item->comments()
            ->latest()
            ->skip($offset)
            ->take(5)
            ->get();

        return response()->json([
            'comments' => view('partials.comments', compact('comments'))->render(),
            'nextOffset' => $offset + 5,
        ]);
    }
}
