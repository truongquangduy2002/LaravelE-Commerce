<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brandData = Brand::all();
        return view('backend.brand.all_brand', compact('brandData'));
    }

    public function AddBrand()
    {
        return view('backend.brand.add_brand');
    }

    public function StoreBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'brand_image' => [
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
            'brand_name.required' => 'Vui lòng nhập tên.',
            'brand_name.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'brand_image.required' => 'Vui lòng nhập ảnh.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Lưu ảnh vào thư mục upload
        $sliderImage = $request->file('brand_image');
        $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
        $sliderImage->move(public_path('upload/brands'), $sliderImageName);
        $save_url = 'upload/brands/' . $sliderImageName;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            'brand_image' => $save_url,
        ]);

        // Redirect hoặc trả về thông báo thành công
        $notification = array(
            'message' => 'Brand đã được thêm thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.brand')->with($notification);
    }

    public function EditBrand($id)
    {
        $brandData = Brand::find($id);
        return view('backend.brand.edit_brand', compact('brandData'));
    }

    public function UpdateBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'brand_image' => [
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
            'brand_name.required' => 'Vui lòng nhập tên.',
            'brand_name.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $brand_id = $request->id;
        $oldImage = $request->input('old_image');

        if (!empty($oldImage)) {
            // Xóa ảnh cũ
            if (file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }

        if ($request->hasFile('brand_image')) {
            $sliderImage = $request->file('brand_image');
            $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
            $sliderImage->move(public_path('upload/brands'), $sliderImageName);
            $save_url = 'upload/brands/' . $sliderImageName;

            Brand::find($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
            ]);

            // Redirect hoặc trả về thông báo thành công
            $notification = array(
                'message' => 'Brand đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.brand')->with($notification);
        } else {

            if (!$request->hasFile('brand_image')) {
                Brand::findOrFail($brand_id)->update([
                    'brand_name' => $request->brand_name,
                    'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                ]);
            }

            $notification = array(
                'message' => 'Brand đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.brand')->with($notification);
        };
    }

    public function DeleteBrand($id)
    {
        $brand = Brand::findOrFail($id);

        $image_path = public_path($brand->brand_image);

        if (File::exists($image_path)) {
            unlink($image_path);
        }

        $brand->delete();

        $notification = array(
            'message' => 'Brand đã được xóa thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.brand')->with($notification);
    }
}
