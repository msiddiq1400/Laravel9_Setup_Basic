<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function allBrands() {
        $brands = Brand::paginate();
        return view('admin.brand.index', compact('brands'));
    }

    public function addBrand(Request $request) {
        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name|max:30',
            'brand_image' => 'required|mimes:png,jpg'
        ]);

        $brand = new Brand();
        $brand->brand_name = $request->brand_name;

        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'images/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        $brand->brand_image = $last_img;

        $brand->save();

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }
}