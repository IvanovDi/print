<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'active',
        'is_page',
        'show_in_navigation',
        'category_id',
        'slug',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'image',
        'thumbnail',
        'theme_id',
    ];

    protected $appends = [
        'image_full_path',
        'thumbnail_full_path',
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function themes()
    {
        return $this->belongsTo(Themes::class, 'theme_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageFullPathAttribute()
    {
        return \Config::get('uploadFile.category.viewPath'). '/' . $this->image;
    }

    public function getThumbnailFullPathAttribute()
    {
        return \Config::get('uploadFile.category.viewPath'). '/' . $this->thumbnail;
    }

}

