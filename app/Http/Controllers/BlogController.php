<?php

namespace App\Http\Controllers;

use App\Models\Admin\Blog\BlogCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Admin\Blog\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Blog\BlogComment;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use App\Models\PageTitle;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::withCount("comments")
            ->with("category")
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            })
            ->where('status', 1)
            ->orderByDesc('id')
            ->paginate(6);

        $blogCategories = BlogCategory::where("status", 1)
            ->withCount("posts")
            ->get();

        $latestComments = BlogComment::where("status", 1)
            ->latest()
            ->take(4)
            ->get();



        $pageTitle = PageTitle::where('page_identifier', 'blog')->first();

        return view('frontend.blog.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_description')->value,
            'site_image' => asset('img/logo/logo_big.jpg'),
            'page_name' => Setting::find('app_tagline')->value,
            'posts' => $posts,
            'pageTitle' => $pageTitle,
            'blogCategories' => $blogCategories,
            'latestComments' => $latestComments,
            'totalCategories' => count($blogCategories),
        ]);
    }

    public function show(Post $post)
    {
        $blogCategories = BlogCategory::where("status", 1)
            ->withCount("posts")
            ->get();
        $comments = $post->comments()
            ->where("status", 1)
            ->with("commentedBy")
            ->paginate();

        $pageTitle = PageTitle::where('page_identifier', 'blog')->first();

        return view('frontend.blog.show')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Str::limit($post->description, 155, '...'),
            'site_image' => asset('img/logo/logo_big.jpg'),
            'page_name' => $post->title,
            'post' => $post,
            'blogCategories' => $blogCategories,
            'comments' => $comments,
            'pageTitle' => $pageTitle,
            'totalCategories' => count($blogCategories),
        ]);
    }

    public function store_comment(Request $request, Post $post, FlasherInterface $flasher)
    {

        if (!auth()->user()->hasVerifiedEmail()) {

            $successMessage = DB::table('success_messages')
                ->where('key', 'user_unverify_comment')
                ->value('message');

            $flasher->addError($successMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle',
                'theme' => 'light'
            ]);

            return back();
        }

        $commentDelay = 60;

        $errorDelayMessage = DB::table('success_messages')
            ->where('key', 'error_delay_comment')
            ->value('message');

        $lastComment = BlogComment::where('commented_by', auth()->id())
            ->where('post_id', $post->id)
            ->latest()
            ->first();

        if ($lastComment && $lastComment->created_at->diffInSeconds(now()) < $commentDelay) {
            $flasher->addError($errorDelayMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle',
                'theme' => 'light'
            ]);

            return back();
        }

        if (strlen($request->comment) < 5) {
            $errorMinMessage = DB::table('success_messages')
                ->where('key', 'error_min_comment')
                ->value('message');


            $flasher->addError($errorMinMessage, 'Error!', [
                'position' => 'top-center',
                'timer' => 5000,
                'icon' => 'check-circle',
                'theme' => 'light'
            ]);

            return back();
        }


        $successMessage = DB::table('success_messages')
            ->where('key', 'comment_post_success')
            ->value('message');

        $new_comments = Setting::find('new_comments')->value;

        $validation = $request->validate([
            'comment' => 'required|string|max:300'
        ]);

        $create = BlogComment::create([
            'comment' => $request->comment,
            'commented_by' => Auth::id(),
            'post_id' => $post->id,
            'status' => $new_comments
        ]);

        if ($create) {
            if ($new_comments == 1) {

                return back()->with('success', 'Your comment is posted.');
            } else {

                $flasher->addInfo($successMessage, 'Success!', [
                    'position' => 'top-center',
                    'timer' => 5000,
                    'icon' => 'check-circle',
                    'theme' => 'light'
                ]);

                return back();
            }
        } else {
            Alert::error(__('app.error_message'));
            return back();
        }
    }

    public function destroy_comment(Request $request, BlogComment $comment)
    {
        if ($comment->isMyComment()) {
            info("hi");
            $comment->delete();
            alert()->success(__('app.you_successfully_delete_the_comment'));
            return back();
        } else {
            alert()->error(__('app.error_message'));
            return back();
        }
    }

    public function show_category(BlogCategory $category)
    {
        $posts = $category->posts()->withCount("comments")
            ->with("category")
            ->where('status', 1)
            ->orderByDesc('id')
            ->paginate(8);

        $blogCategories = BlogCategory::where("status", 1)
            ->withCount("posts")
            ->get();

        $pageTitle = (object)[
            "title" => $category->name,
            "subtitle" => $category->description,
        ];

        return view('frontend.blog.bycategory')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_description')->value,
            'site_image' => asset('img/logo/logo_big.jpg'),
            'page_name' => Setting::find('app_tagline')->value,
            'pageTitle' => $pageTitle,
            'category' => $category,
            'blogCategories' => $blogCategories,
            'totalCategories' => count($blogCategories),
            'posts' => $posts,
        ]);
    }
}
