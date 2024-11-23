<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\PageTitle;
use App\Models\Setting;

class PageController extends Controller
{

    public function __construct()
    {
        //
    }

    public function show($id, $slug)
    {


        $page = Page::query()
            ->where('id', $id)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.page.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Str::limit($page->description, 155, '...'),
            'site_image' => asset('img/logo/logo_big.jpg'),
            'page_name' => $page->title,
            'page' => $page,
            'pageTitle' => $page->title
        ]);
    }
}
