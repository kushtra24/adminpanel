<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * get all categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $category = Category::all();
        return response()->json($category, 200);
    }
}
