<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Image;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Like;
use App\Models\User;
use App\Models\SuccessMessage;
use Alert;
use App\Jobs\SendMemorialApprovalEmail;
use App\Mail\MemorialApproved;
use App\Models\Admin\Blog\BlogComment;
use App\Models\Admin\Blog\Post;
use App\Models\ItemAdditionalImage;
use App\Notifications\NewCommentNotification;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public $new_entries;
    public $new_comments;
    public $flasher;

    public function __construct(FlasherInterface $flasher)
    {
        $this->flasher = $flasher;
        $this->new_entries = Setting::find('new_entries')->value;
        $this->new_comments = Setting::find('new_comments')->value;
    }

    function make_slug($string)
    {
        $string = preg_replace('~[^\\pL\d]+~u', '-', trim($string));
        return Str::lower($string);
    }

    public function index()
    {
        $totalComments = Comment::count() + BlogComment::count();

        return view('admin.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Dashboard'),
            'items' => new Item,
            'categories' => new Category,
            'comments' => new Comment,
            'users' => new User,
            'blogComments' => new BlogComment,
            'totalComments' => $totalComments
        ]);
    }

    public function edit()
    {
        return view('admin.settings')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Settings'),
            'settings' => Setting::first()
        ]);
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'app_name' => 'required|string|min:3',
            'app_tagline' => 'nullable|string|min:3',
            'app_description' => 'nullable|string|max:150',
            'num_of_results' => 'required|numeric|min:1',
            'num_comments_at_time' => 'required|numeric|min:3',
            'app_logo' => 'nullable',
            'new_entries' => 'nullable',
            'new_comments' => 'nullable',
            'recaptcha_site_key' => 'required',
            'recaptcha_secret_key' => 'required',
        ]);

        // Logo processing
        if (!empty(request('app_logo'))) {
            $request->validate([
                'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if (!empty(Setting::find('app_logo')->value)) {
                File::delete('img/logo/' . Setting::find('app_logo')->value);
            }

            $value = Str::random(24) . '.' . $request->file('app_logo')->extension();
            $destinationPath = 'img/logo';

            $img = Image::make($request->file('app_logo')->path());
            $img->save($destinationPath . '/' . $value);
        }

        foreach ($request->all() as $key => $value) {
            Setting::where('name', $key)->update(['value' => $value]);
        }

        $this->flasher->addSuccess(__('Updated changes!'));
        return back();
    }


    public function about()
    {
        return view('admin.about')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('About'),
            'settings' => Setting::first()
        ]);
    }

    public function about_update(Request $request)
    {
        $validation = $request->validate([
            'about' => 'required|string|min:100',
        ]);

        $update = Setting::where('name', 'about')->update([
            'value' => Purify::clean($request->about),
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('Updated changes!'));
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
        }

        return back();
    }


    public function terms()
    {
        return view('admin.terms')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Terms & Conditions'),
            'settings' => Setting::first()
        ]);
    }

    public function terms_update(Request $request)
    {
        $validation = $request->validate([
            'terms' => 'required|string|min:100',
        ]);

        $update = Setting::where('name', 'terms')->update([
            'value' => Purify::clean($request->terms),
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('Updated changes!'));
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
        }

        return back();
    }


    public function logos()
    {
        return view('admin.logos')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Update Logos'),
            'settings' => Setting::first()
        ]);
    }

    public function logos_update(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('logo')) {
                $setting = Setting::where('name', 'app_logo')->first();
                if ($setting && !empty($setting->value)) {
                    $currentImage = public_path('img/logo/' . $setting->value);
                    if (file_exists($currentImage)) {
                        File::delete($currentImage);
                    }
                }

                $file = $request->file('logo');
                $fileName = Str::random(35) . '.' . $file->extension();
                $file->move(public_path('img/logo/'), $fileName);

                $setting->update(['value' => $fileName]);

                $this->flasher->addSuccess(__('The logo has been updated!'));
            }
        } catch (\Exception $e) {
            Log::error('Logo update error: ' . $e->getMessage());
            $this->flasher->addError(__('A problem has been encountered, try again!'));
        }

        return back();
    }



    public function users()
    {
        return view('admin.users.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Users'),
            'users' => User::orderByDesc('created_at')->paginate(15),
        ]);
    }

    public function user_edit($id)
    {
        return view('admin.users.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Users'),
            'user' => User::findOrFail($id),
            'roles' => \Spatie\Permission\Models\Role::all(),
        ]);
    }

    public function user_update(Request $request, $id)
    {
        if (!empty($request->new_password)) {
            $this->validate($request, [
                'new_password' => 'required|min:8',
                'new_confirm_password' => 'same:new_password',
            ]);

            $update = User::where('id', $id)
                ->update(['password' => bcrypt($request->new_password)]);

            if ($update) {
                $this->flasher->addSuccess(__('Password updated!'));
                return redirect()->route('admin.user.edit', $id);
            } else {
                $this->flasher->addError(__('A problem has been encountered, try again!'));
                return back();
            }
        }

        $request->validate([
            'name' => 'required|max:150|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id,
        ]);

        $user = User::find($id);
        if ($request->has('remove_avatar')) {
            $user->avatar = null;
        }

        $update = $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->roles()->detach();
        $user->roles()->attach(\Spatie\Permission\Models\Role::where('name', $request->role)->first());

        if ($request->has('verify_email') && $request->verify_email) {
            $user->markEmailAsVerified();
        } else {
            $user->email_verified_at = null;
            $user->save();
        }

        if ($update) {
            $this->flasher->addSuccess(__('Updated changes!'));
            return redirect()->route('admin.user.edit', $id);
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }


    public function user_destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->getRoleNames() == collect(['admin'])) {
            $this->flasher->addError(__('You can\'t delete Admin!'));
            return back();
        }

        // Remove avatar
        if (!is_null($user->avatar)) {
            File::delete(public_path('img/avatar/' . $id) . '/' . $user->avatar);
        }

        $delete = User::where('id', $id)->delete();

        if ($delete) {
            $this->flasher->addSuccess(__('User deleted successfully!'));
            return redirect()->route('admin.users');
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }



    // Obituaries


    public function obituaries()
    {

        $message = SuccessMessage::where('key', 'memorial_post_success')->first();

        return view('admin.obituaries.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Obituaries'),
            'obituaries' => Item::orderBy('status', 'desc')->latest()->paginate(25),
            'message' => $message
        ]);
    }

    public function obituary_create()
    {

        return view('admin.obituaries.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create Obituary')
        ]);
    }

    public function obituaries_message(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        try {
            $updated = SuccessMessage::where('key', 'memorial_post_success')
                ->update(['message' => $request->input('message')]);

            if ($updated) {
                $this->flasher->addSuccess(__('Successfully Updated!'));
            } else {
                $this->flasher->addError(__('No changes were made.'));
            }
        } catch (\Exception $e) {
            Log::error('Error updating obituary message: ' . $e->getMessage());
            $this->flasher->addError(__('A problem has been encountered, try again!'));
        }

        return redirect()->back();
    }

    public function delete_aditional_image($id)
    {

        $previousAdditionalImages = ItemAdditionalImage::find($id);

        $oldFilePath = public_path('img/obituary/' . $previousAdditionalImages->item_id . '/additional/' . $previousAdditionalImages->filename);

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $previousAdditionalImages->delete();

        $this->flasher->addSuccess(__('Successfully Deleted!'));

        return back();
    }


    public function delete_cover_image(Image $image)
    {
        $oldFilePath = public_path('img/obituary/' . $image->imageable_id . '/' . $image->filename);

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $image->delete();

        $this->flasher->addSuccess(__('Successfully Deleted!'));

        return back();
    }

    public function comment_message(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        SuccessMessage::where('key', 'comment_post_success')->update([
            'message' => $request->input('message'),
        ]);

        $this->flasher->addSuccess(__('Successfully Updated!'));
        return redirect()->back();
    }

    public function obituary_store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|string|min:150',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sex' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'death_date' => 'required|date',
            'funeral_place' => 'nullable|string|min:1|max:150',
        ]);

        $create = Item::create([
            'title' => $request->title,
            'description' => Purify::clean($request->description),
            'user_id' => Auth::id(),
            'category_id' => $request->category,
            'slug' => $this->make_slug($request->title),
            'status' => $request->status,
            'terms' => 1
        ]);

        if ($create) {
            Detail::create([
                'sex' => $request->sex,
                'birth_date' => $request->birth_date,
                'death_date' => $request->death_date,
                'funeral_place' => $request->funeral_place,
                'item_id' => $create->id,
            ]);
        }

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = Str::random(35) . '.' . $file->extension();
            $file->move(public_path('img/obituary/' . $create->id), $name);

            Image::create([
                'filename' => $name,
                'imageable_id' => $create->id,
                'imageable_type' => 'App\Models\Item'
            ]);
        }

        if ($create) {
            $this->flasher->addSuccess(__('Successfully posted!'));
            return redirect()->route('admin.obituaries');
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }


    public function obituary_edit($id)
    {
        $item = Item::findOrFail($id);

        return view('admin.obituaries.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edi Obituary'),
            'item' => $item
        ]);
    }

    public function obituary_update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|string|min:150',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sex' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'death_date' => 'required|date',
            'funeral_place' => 'nullable|string|min:1|max:150',
        ]);

        if ($request->hasfile('image')) {
            $item = Item::findOrFail($request->id);

            $currentImage = public_path('img/obituary/' . $item->id . '/' . $item->thumb->filename);
            if (file_exists($currentImage)) {
                File::delete($currentImage);
            }

            $file = $request->file('image');
            $name = Str::random(35) . '.' . $file->extension();
            $file->move(public_path('img/obituary/' . $request->id), $name);

            Image::where('imageable_id', $request->id)->update([
                'filename' => $name,
            ]);
        }

        $update = Item::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => Purify::clean($request->description),
            'category_id' => $request->category,
            'slug' => $this->make_slug($request->title),
            'status' => $request->status,
            'terms' => 1
        ]);

        Detail::where('item_id', $request->id)->update([
            'sex' => $request->sex,
            'birth_date' => $request->birth_date,
            'death_date' => $request->death_date,
            'funeral_place' => $request->funeral_place,
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('The item has been updated!'));
            return back();
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function obituary_destroy($id)
    {
        $item = Item::findOrFail($id);

        $currentImage = public_path('img/obituary/' . $item->id);
        if (file_exists($currentImage)) {
            File::deleteDirectory($currentImage);
        }

        $delete = $item->delete();

        $this->flasher->addSuccess(__('Successfully deleted!'));
        return redirect()->route('admin.obituaries');
    }

    public function obituary_delete_all(Request $request)
    {
        $ids = $request->ids;
        $images = explode(",", $ids);

        foreach ($images as $image) {
            $image_path = public_path('img/obituary/' . $image);
            File::deleteDirectory($image_path);
        }

        $deleteAll = Item::whereIn('id', explode(",", $ids))->delete();

        return response()->json(['success' => __("Items deleted successfully.")]);
    }


    // Categories

    public function categories()
    {

        return view('admin.categories.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Categories'),
            'categories' => Category::orderBy('status', 'desc')->oldest()->paginate(25)
        ]);
    }

    public function category_create()
    {

        return view('admin.categories.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create New Category')
        ]);
    }

    public function category_edit($id)
    {

        return view('admin.categories.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Category'),
            'category' => Category::findOrFail($id)
        ]);
    }

    public function category_store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'required|string|min:5',
            'status' => 'required'
        ]);


        $create = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $this->make_slug($request->name),
            'status' => $request->status,
        ]);

        if ($create) {
            $this->flasher->addSuccess(__('The category has been created!'));
            return redirect()->route('admin.categories');
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function category_update(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:categories,name,' . $request->id,
            'description' => 'required|string|min:5',
            'status' => 'required'
        ]);

        $update = Category::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $this->make_slug($request->name),
            'status' => $request->status,
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('The category has been updated!'));
            return back();
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function category_destroy($id)
    {
        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {
            $image_path = public_path('img/obituary/' . $item->id);
            File::deleteDirectory($image_path);
        }

        $delete = Category::findOrFail($id)->delete();

        $this->flasher->addSuccess(__('Successfully deleted!'));
        return back();
    }



    // Comments

    public function comments()
    {

        $message = SuccessMessage::where('key', 'comment_post_success')->first();

        return view('admin.comments.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Comments'),
            'comments' => Comment::orderBy('status', 'desc')->latest()->paginate(15),
            'message' => $message
        ]);
    }

    public function comment_edit($id)
    {

        return view('admin.comments.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Comment'),
            'comment' => Comment::findOrFail($id)
        ]);
    }

    public function comment_update(Request $request)
    {
        $validation = $request->validate([
            'content' => 'required|string|min:5',
            'status' => 'required'
        ]);

        $update = Comment::where('id', $request->id)->update([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('The comment has been updated!'));
            return back();
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function comment_destroy($id)
    {

        $delete = Comment::findOrFail($id)->delete();


        $this->flasher->addSuccess(__('Successfully deleted!'));
        return back();
    }



    // Pages

    public function pages()
    {

        return view('admin.pages.index')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Pages'),
            'pages' => Page::orderBy('status', 'desc')->latest()->paginate(25)
        ]);
    }

    public function page_create()
    {

        return view('admin.pages.create')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Create Page')
        ]);
    }

    public function page_edit($id)
    {

        return view('admin.pages.edit')->with([
            'site_name' => Setting::find('app_name')->value,
            'site_description' => Setting::find('app_tagline')->value,
            'page_name' => __('Edit Page'),
            'page' => Page::findOrFail($id)
        ]);
    }

    public function page_store(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:150',
            'content' => 'required|string|min:5',
            'status' => 'required'
        ]);

        $create = Page::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => Purify::clean($request->content),
            'slug' => $this->make_slug($request->title),
            'status' => $request->status,
        ]);

        if ($create) {
            $this->flasher->addSuccess(__('The page has been created!'));
            return redirect()->route('admin.pages');
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function page_update(Request $request)
    {
        $validation = $request->validate([
            'title' => 'required|unique:pages,title,' . $request->id,
            'description' => 'required|string|max:150',
            'content' => 'required|string|min:5',
            'status' => 'required'
        ]);

        $update = Page::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => Purify::clean($request->content),
            'slug' => $this->make_slug($request->title),
            'status' => $request->status,
        ]);

        if ($update) {
            $this->flasher->addSuccess(__('The page has been updated!'));
            return back();
        } else {
            $this->flasher->addError(__('A problem has been encountered, try again!'));
            return back();
        }
    }

    public function page_destroy($id)
    {
        $delete = Page::findOrFail($id)->delete();

        $this->flasher->addSuccess(__('Successfully deleted!'));
        return back();
    }

    // Change_Status


    public function change_status(Request $request)
    {
        $table = $request->table;
        $table_name = null;

        if ($table == "item") {
            $table_name = new Item;
        } elseif ($table == "comment") {
            $table_name = new Comment;
        } elseif ($table == "category") {
            $table_name = new Category;
        } elseif ($table == 'blogComment') {
            $table_name = new BlogComment;
        } elseif ($table == 'post') {
            $table_name = new Post;
        } else {
            $table_name = new Page;
        }

        $item = $table_name->findOrFail($request->id);

        $newStatus = $item->getStatus() ? '0' : '1';
        $item->status = $newStatus;
        $item->save();


        if ($table == 'comment' && $newStatus == '1') {
            $memorial = $item->item;
            $memorialOwner = $memorial->user;

            $memorialOwner->notify(new NewCommentNotification($memorial, $item));
        }

        if ($table == 'item' && $item->status == '1') {
            $memorial = $item;

            Mail::to($memorial->user->email)->send(new MemorialApproved($memorial));
        }

        return response()->json([
            'bool' => $newStatus,
            'table' => $table,
        ]);
    }
}
