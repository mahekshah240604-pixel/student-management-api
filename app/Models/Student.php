<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'mobile',
        'course',
        'address',
        'class',
        'image',
    ];
}