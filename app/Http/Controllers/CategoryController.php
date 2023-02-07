<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function allCategories() {
        $categories = Category::paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    public function addCategory(Request $request) {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name|max:30'
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }
}