<?php

namespace App\Repositories;

use App\Entities\Product;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

}