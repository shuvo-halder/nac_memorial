<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_code',
        'error_title',
        'error_message'
    ];
}
