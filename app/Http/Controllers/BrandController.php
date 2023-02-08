<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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

        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('images/brand/'.$name_gen);
        $last_img = 'images/brand/'.$name_gen;

        $brand->brand_image = $last_img;

        $brand->save();

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function editBrand($id) {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function updateBrand(Request $request, $id) {
        $request->validate([
            'brand_name' => 'required|min:4',
        ],[
            //custom msg for validation
            'brand_name.required' => 'Plz Input Brand Name'
        ]);

        $brand = Brand::find($id);
        $brand->brand_name = $request->brand_name;

        if($request->file('brand_image')) {
            unlink($request->old_image);
            $brand_image = $request->file('brand_image');
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'images/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
            $brand->brand_image = $last_img;
        }
        $brand->save();
        return Redirect()->route('all.brand')->with('success', 'Brand Updated Successfully');
    }

    public function deleteBrand($id) {
        $brand = Brand::find($id);
        unlink($brand->brand_image);
        $brand->delete();
        return Redirect()->back()->with('success', 'Brand Deleted Successfully');
    }
}