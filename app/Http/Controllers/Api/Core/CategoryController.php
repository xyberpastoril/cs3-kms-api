<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Category\StoreCategoryRequest;
use App\Http\Requests\Api\Core\Category\UpdateCategoryRequest;
use App\Models\Core\Category;
// use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * This function shows all the categories.
     */
    public function showAll()
    {
        // TODO: Implement showAll()
    }

    /**
     * This function stores a category.
     * 
     * It can only be done by admins.
     */
    public function store(StoreCategoryRequest $request)
    {
        // TODO: Implement store()
    }

    /**
     * This function updates a category.
     * 
     * It can only be done by admins.
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        // TODO: Implement update()
    }

    /**
     * This function destroys a category. Questions part of it won't be
     * affected.
     * 
     * It can only be done by admins.
     */
    public function destroy(Category $category)
    {
        // TODO: Implement destroy()
    }
}
