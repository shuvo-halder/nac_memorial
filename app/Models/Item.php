<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Muhaimenul\Larasearch\Traits\LaraSearch;

class Item extends Model
{

    use Likeable, LaraSearch;

    protected $table = 'items';

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'slug',
        'status'
    ];

    /**
     * Columns that are considered for search results.
     *
     * @var array
     */
    protected $searchable = [
        'title',
        'description',
    ];

    function getThumb()
    {
        if ($this->thumb()->exists()) {
            return 'img/obituary/' . $this->id . '/' . $this->thumb->filename;
        } else {
            return 'img/components/no_images.jpg';
        }
    }

    function getStatus()
    {
        if ($this->status == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id')
            ->where('status', 1);
    }

    public function thumb()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function details()
    {
        return $this->hasOne(Detail::class);
    }

    public function condolences()
    {
        return $this->morphMany(Like::class, 'likeable')->orderByDesc('created_at');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'item_id');
    }

    public function additionalImages()
    {
        return $this->hasMany(ItemAdditionalImage::class);
    }
}
