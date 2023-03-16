<?php

namespace App\Services;
use App\Models\Category;

class CategoryService extends BaseService
{
    public function getAllCategory()
    {
        return Category::paginate(10);
    }

}