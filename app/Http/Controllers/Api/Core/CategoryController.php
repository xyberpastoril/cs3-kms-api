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
     * TODO: This function shows all the categories.
     * 
     * @return JsonResponse
     */
    public function showAll()
    {

    }

    /**
     * TODO: This function stores a category.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {

    }

    /**
     * TODO: This function updates a category.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {

    }

    /**
     * TODO: This function destroys a category. Questions part of it won't be
     * affected.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        
    }
}
