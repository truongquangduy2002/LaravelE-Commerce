<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\preg_quote;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categoriesData = Category::all();
        return view('backend.category.all_category', compact('categoriesData'));
    }

    public function AddCategory()
    {
        return view('backend.category.add_category');
    }

    public function StoreCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s&]+$/',
            ],
            'category_slug' => [
                'required',
            ],
            'category_image' => [
                'required',
                'image',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());

                    if (!in_array($extension, ['png', 'jpeg', 'jpg', 'gif'])) {
                        $fail('Ảnh không hợp lệ. Vui lòng chọn một ảnh có định dạng PNG, JPEG, JPG hoặc GIF.');
                    }
                },
                // 'regex:/\.(jpg|jpeg|png|gif)$/i',
            ],
            // Các quy tắc xác thực khác
        ], [
            'category_name.required' => 'Vui lòng nhập tên.',
            'category_name.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'category_image.required' => 'Vui lòng nhập ảnh.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Kiểm tra nếu giá trị của trường slug giống với giá trị của trường name
        if ($request->category_slug === $request->category_name) {
            // Xử lý lỗi và trả về thông báo
            return redirect()->back()->withErrors(['error' => 'Slug phải giống hoàn toàn với tên đặt tiêu đề.'])->withInput();
        }

        // $category = new Category();
        // $category->category_name = $request->category_name;
        // $category->category_slug = $request->category_slug;

        // Kiểm tra nếu có tệp tin ảnh được tải lên
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/categories'), $image_name);
            $save_path = 'upload/categories/' . $image_name;

            // Lưu đường dẫn ảnh vào cơ sở dữ liệu
            // $category->category_image = 'upload/categories/' . $image_name;
        }
        // else {
        //     $category->category_image = '';
        // }

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_image' => $save_path,
        ]);

        // Lưu dữ liệu vào cơ sở dữ liệu
        // $category->save();

        // Thông báo thành công và chuyển hướng trở lại trang danh sách
        return redirect()->route('all.category')->with('success', 'Dữ liệu đã được thêm thành công.');
    }

    public function EditCategory($id)
    {
        $categoriesData = Category::find($id);
        return view('backend.category.edit_category', compact('categoriesData'));
    }

    public function UpdateCategory(Request $request)
    {
        $cat_id = $request->id;
        $old_img = $request->old_image;

        if (!empty($old_img)) {

            // Xóa ảnh cũ
            if (file_exists(public_path($old_img))) {
                unlink(public_path($old_img));
            }
        }

        if ($request->file('category_image')) {
            // Xử lý khi không có lỗi validate
            if ($request->hasFile('category_image')) {
                // Lưu ảnh vào thư mục upload
                $sliderImage = $request->file('category_image');
                $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
                Image::make($sliderImage)->resize(2376, 807)->save('upload/categories/' . $sliderImageName);
                $save_url = 'upload/categories/' . $sliderImageName;

                Category::findOrFail($cat_id)->update([
                    'category_name' => $request->category_name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                    'category_image' => $save_url,
                ]);

                // Redirect hoặc trả về thông báo thành công
                $notification = array(
                    'message' => 'Slider đã được sửa thành công.',
                    'alert-type' => 'success'
                );

                return redirect()->route('all.category')->with($notification);
            }
        } else {

            if (!$request->hasFile('category_image')) {
                Category::findOrFail($cat_id)->update([
                    'category_name' => $request->category_name,
                    'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                ]);
            }

            $notification = array(
                'message' => 'Slider đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        }
    }

    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);

        $image_path = public_path($category->category_image);

        if (File::exists($image_path)) {
            unlink($image_path);
        }

        $category->delete();

        $notification = array(
            'message' => 'Category đã được xóa thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
    }
}
