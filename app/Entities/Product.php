<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Backend\Entities\Addon;
use Modules\Backend\Entities\ProductPrice;

class Product extends Model
{
    const TYPE_GENERAL = 'general';
    const TYPE_PRINTED = 'printed';
    const MAX_PRICE_SIZE = 99999;

    public static $displayTypes = [
        self::TYPE_GENERAL => 'General',
        self::TYPE_PRINTED => 'Printed',
    ];

    protected $fillable = [
        'name',
        'image',
        'type',
    ];

    protected $appends = [
        'image_full_path',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'addon_product');
    }

    public function getImageFullPathAttribute()
    {
        return \Config::get('uploadFile.products.viewPath'). '/' . $this->image;
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

}
