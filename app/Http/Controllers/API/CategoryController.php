<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category() {
        $categories = Category::where("status", 1)->get();
        return response()->json([
            'data' => $categories
        ],200);
    }
}
