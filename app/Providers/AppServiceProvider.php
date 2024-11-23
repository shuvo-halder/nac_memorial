<?php

namespace App\Providers;

use App\Models\Admin\Blog\BlogComment;
use App\Models\Admin\Blog\Post;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\Page;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Category;
use App\Models\FooterDescription;
use App\Models\Item;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Category list
        View::share('categories', Category::with('subcategory')->whereNull('parent_id')->where('status', '1')->orderBy('id', 'ASC')->get());

        View::share('condolences', Like::whereHas('item', function ($q) {
            $q->where('status', 1);
        })->orderByDesc('created_at')->take(5)->get());

        View::share('latestComments', Comment::whereHas('itemsFilter', function ($q) {
            $q->where('status', 1);
        })->where('status', 1)->orderByDesc('created_at')->take(6)->get());

        View::share('pages', Page::where('status', 1)->orderByDesc('id')->get());

        View::share('settings', Setting::first());
        Carbon::setLocale(config('locale'));

        View::share('socialLinks', SocialLink::all());
        View::share('footerDescription', FooterDescription::all()->first());

        // Pagination
        Paginator::useBootstrap();

        View::share('totalMemorial', Item::where('status', 1)->count());
        View::share('totalUser', User::count());
        View::share('totalMemorialComment', Comment::where('status', 1)->count());
        View::share('totalBlogComment', BlogComment::where('status', 1)->count());
        View::share('totalBlog', Post::where('status', 1)->count());
    }
}
