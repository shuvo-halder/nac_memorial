<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Blog\BlogCategory;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Log;

class BlogCategoryController extends Controller
{

    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
    }


    public function index()
    {
        return view('admin.blog.categories.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Categories'),
            'categories' => BlogCategory::orderBy('status', 'desc')->latest()->paginate(25)
        ]);
    }

    public function create()
    {
        return view('admin.blog.categories.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create New Category')
        ]);
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'required|string|min:5',
            'status' => 'required'
        ]);

        try {
            BlogCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
                'status' => $request->status,
            ]);


            $this->flasher->addSuccess(__('The category has been created!'));
            return redirect()->route('admin.blog.categories');
        } catch (\Exception $e) {
            Log::error($e);


            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Category'),
            'category' => $category
        ]);
    }

    public function update(Request $request, BlogCategory $category)
    {
        $validation = $request->validate([
            'name' => 'required|unique:categories,name,' . $request->id,
            'description' => 'required|string|min:5',
            'status' => 'required'
        ]);

        try {
            $update = $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::slug($request->name),
                'status' => $request->status,
            ]);

            $this->flasher->addSuccess(__('The category has been updated!'));
            return back();
        } catch (\Exception $e) {
            Log::error($e);

            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function destroy(BlogCategory $category)
    {
        try {
            $delete = $category->delete();

            $this->flasher->addSuccess(__('Successfully deleted!'));
            return back();
        } catch (\Exception $e) {
            Log::error($e);

            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }
}
