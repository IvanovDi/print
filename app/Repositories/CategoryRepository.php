<?php

namespace App\Repositories;

use App\Entities\Category;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }

    public function delete($id)
    {
        if ($this->model->whereHas('category')->where('id', $id)->get()->isEmpty()) {
            parent::delete($id);
        } else {
            \Message::warning(['You can\'t delete this category']);
        }
    }

    public function getCategories()//TODO recursion
    {
        $categories = $this->model->where(['category_id' => null])->get();

        if (count($categories) > 0) {
            foreach ($categories as $category) {
                if (count($category->category) > 0) {
                    $this->countRelation($category);
                }
            }
        }
        return $categories;
    }

    protected function countRelation($data)//TODO recursion
    {
        if (count($data->category) > 0) {
            foreach ($data->category as $category) {
                $this->countRelation($category);
            }
        }

    }
}