<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\Admin\Blog\BlogCategory;
use App\Models\Image;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Blog\Post;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{


    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.posts.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Categories'),
            'posts' => Post::with('category')
                ->orderByRaw("status = 0 DESC")
                ->latest()
                ->paginate(25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.posts.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create New Post'),
            'categories' => BlogCategory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|unique:posts,title',
            'thumbnail' => 'nullable|image|max:2024',
            'description' => 'nullable|string|min:5',
            'body' => 'required|string|min:5',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|boolean'
        ]);

        try {
            DB::beginTransaction();

            $post = Post::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'body' => $request->body,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            if ($request->hasFile('thumbnail')) {
                $this->storeOrUpdateThumbnail($request->file("thumbnail"), $post);
            }

            DB::commit();
            $this->flasher->addSuccess(__('The post has been created.'));
            return redirect()->route("admin.blog.posts");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e);
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.blog.posts.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.blog.posts.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Post'),
            'categories' => BlogCategory::get(),
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validation = $request->validate([
            'title' => ['string', Rule::unique("posts", "title")->ignore($post->id)],
            'thumbnail' => 'nullable|image|max:2024',
            'description' => 'required|string|min:5',
            'body' => 'required|string|min:5',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $this->storeOrUpdateThumbnail($request->file("thumbnail"), $post);
            }

            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'body' => $request->body,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);

            DB::commit();
            $this->flasher->addSuccess(__('The post has been updated!'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();
            $image_path = public_path('img/posts/' . $post->id);
            File::deleteDirectory($image_path);

            $post->thumbnail()->delete();

            $post->delete();

            DB::commit();

            $this->flasher->addSuccess(__('Successfully deleted!'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return redirect()->back();
        }
    }

    /**
     * Store or update the thumbnail image.
     *
     * @param  UploadedFile  $thumbnail
     * @param  Post  $post
     * @return void
     */
    public function storeOrUpdateThumbnail(UploadedFile $thumbnail, Post $post)
    {
        if ($post->thumbnail()->exists()) {
            $currentImage = public_path('img/posts/' . $post->id . '/' . $post->thumbnail->filename);
            if (file_exists($currentImage)) {
                File::delete($currentImage);
            }
        }

        $name = Str::random(35) . '.' . $thumbnail->extension();
        $thumbnail->move(public_path('img/posts/' . $post->id), $name);

        $post->thumbnail()->updateOrCreate([
            "imageable_id" => $post->id
        ], [
            'filename' => $name
        ]);
    }
}
