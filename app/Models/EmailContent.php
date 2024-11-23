<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailContent extends Model
{
    protected $fillable = [
        'key',
        'subject',
        'title',
        'sub_title',
        'content',
        'footer'
    ];
}
