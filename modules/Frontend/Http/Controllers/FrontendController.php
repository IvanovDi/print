<?php

namespace Modules\Frontend\Http\Controllers;

use App\Entities\Category;
use Illuminate\Http\Request;

class FrontendController extends BaseFrontendController
{

    public function index()
    {
        return $this->view('index');
    }

    public function showCategory($url)
    {
        $urls = explode('/', $url);
        $categories = Category::whereIn('slug', $urls)->get();
        if (count($urls) != count($categories)) {
            abort(404);
        }
        $count = 1;
        $previousCategory = null;
        foreach ($urls as $category) {
            $currentCategory = $this->getCategoryBySlug($categories, $category);
            if ($count === 1) {
                if ($currentCategory->category_id !== null) { // check if root
                    abort(404);
                }
            } else {
                if ($currentCategory->category_id != $previousCategory->id) { // check correct relation
                    abort(404);
                }
            }
            $previousCategory = $currentCategory;
            $count++;
        }

        return $this->renderTheme($currentCategory->theme_id);
    }

    protected function renderTheme($themeId)
    {
        return view('themes.' . $themeId);
    }

    protected function getCategoryBySlug($categories, $slug)
    {
        foreach ($categories as $category) {
            if ($category->slug == $slug) {
                return $category;
            }
        }
        abort(404);
    }

    public function showProducts($product)
    {
        return $this->view('products.index', [
            'product' => $product
        ]);
    }
}
