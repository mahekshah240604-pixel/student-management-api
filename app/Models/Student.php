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

    // SEO
    'seo_meta_title',
    'seo_meta_description',
    'seo_meta_keywords',
    'seo_canonical',
    'seo_meta_image',

    // Open Graph
    'og_meta_title',
    'og_meta_description',
    'og_meta_image',
];
}