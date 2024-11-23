<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\BlogComment;
use App\Models\SuccessMessage;
use Flasher\Prime\FlasherInterface;

class BlogCommentController extends Controller
{

    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }

    public function index()
    {
        $comments = BlogComment::with("commentedBy", "post")->latest()->paginate(15);

        return view('admin.blog.comments.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Comments'),
            'comments' => $comments
        ]);
    }

    public function edit(BlogComment $comment)
    {
        return view('admin.blog.comments.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Comment'),
            'comment' => $comment
        ]);
    }

    public function update(Request $request, BlogComment $comment)
    {
        $validation = $request->validate([
            'comment' => 'required|string|min:5',
            'status' => 'required'
        ]);

        try {

            $comment->update([
                'comment' => $request->comment,
                'status' => $request->status,
            ]);


            $this->flasher->addSuccess(__('The comment has been updated!'));
            return back();
        } catch (\Exception $e) {

            Log::error($e);

            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function destroy(BlogComment $comment)
    {
        try {
            $comment->delete();

            $this->flasher->addSuccess(__('Comment deleted!'));
            return back();
        } catch (\Exception $e) {
            Log::error($e);

            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }
}
