<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function allCategories() {
        $categories = Category::paginate(5);
        $trashCat = Category::onlyTrashed()->paginate(3);
        return view('admin.category.index', compact('categories', 'trashCat'));
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

    public function editCategory($id) {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id) {
        $category = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    public function deleteCategory($id) {
        Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Deleted Successfully');
    }

    public function restoreCategory($id) {
        Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('trash_success', 'Category Restored Successfully');
    }

    public function permanentDeleteCategory($id) {
        Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('trash_success', 'Category Deleted Successfully');
    }
}