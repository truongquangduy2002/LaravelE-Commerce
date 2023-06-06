<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.all_subcategory', compact('subcategories'));
    }

    public function AddSubCategory()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('backend.subcategory.add_subcategory', compact('categories'));
    }

    public function StoreSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => [
                'required'
            ],
            'subcategory_name' => [
                'required',
                // 'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            [
                'category_id.required' => 'Vui lòng chọn một danh mục.',
                'subcategory_name.required' => 'Vui lòng nhập tên.',
                'subcategory_name.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            ],
        ]);

        // Kiểm tra nếu chọn mục rỗng
        if ($request->input('category_id') === '') {
            // Xử lý lỗi ở đây
            // Ví dụ: Trả về thông báo lỗi và redirect trở lại form
            return redirect()->back()->with('error', 'Vui lòng chọn một danh mục.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        // Redirect hoặc trả về thông báo thành công
        $notification = array(
            'message' => 'SubCategory đã được thêm thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.sub_category')->with($notification);
    }

    public function GetSubCategory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return json_encode($subcat);
    } // End Method 
}
