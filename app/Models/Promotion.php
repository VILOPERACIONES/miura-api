<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'link',
        'image_desktop',
        'image_mobile',
        'is_active',
    ];
}
