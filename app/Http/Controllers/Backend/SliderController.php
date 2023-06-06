<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Slider;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function AllSlider()
    {
        $sliderData = Slider::all();
        return view('backend.slider.all_slider', compact('sliderData'));
    }

    public function AddSlider()
    {
        return view('backend.slider.add_slider');
    }

    public function StoreSlider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slider_title' => [
                'required',
                'string',
                "regex:/^[a-zA-Z0-9\s'%]+$/",
            ],
            'short_title' => [
                'required',
                'string',
                "regex:/^[a-zA-Z0-9\s'%]+$/",
            ],
            'slider_image' => [
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
            'slider_title.required' => 'Vui lòng nhập tên.',
            'slider_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'short_title.required' => 'Vui lòng nhập tên.',
            'short_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'slider_image.required' => 'Vui lòng chọn ảnh.',
            // 'slider_image.regex' => 'Ảnh không hợp lệ. Vui lòng chọn một ảnh có định dạng (jpg, jpeg, png, gif).',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Xử lý khi không có lỗi validate
        if ($request->hasFile('slider_image')) {
            // Lưu ảnh vào thư mục upload
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()) . '_' . $image->getClientOriginalExtension();
            Image::make($image)->resize(2376, 807)->save('upload/sliders/' . $name_gen);
            $save_url = 'upload/sliders/' . $name_gen;
        }

        // // Redirect hoặc trả về thông báo thành công
        // return redirect()->back()->with('success', 'Ảnh đã được tải lên thành công.');

        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save_url,
        ]);

        // Redirect hoặc trả về thông báo thành công
        $notification = array(
            'message' => 'Slider đã được thêm thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id)
    {
        $sliderData = Slider::findOrFail($id);
        return view('backend.slider.edit_slider', compact('sliderData'));
    }

    public function UpdateSlider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slider_title' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'short_title' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'slider_image' => [
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
            'slider_title.required' => 'Vui lòng nhập tên.',
            'slider_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'short_title.required' => 'Vui lòng nhập tên.',
            'short_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slider_id = $request->id;
        $oldImage = $request->old_image;

        if (!empty($oldImage)) {
            // Xóa ảnh cũ
            if (file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }

        if ($request->file('slider_image')) {
            // Xử lý khi không có lỗi validate
            if ($request->hasFile('slider_image')) {
                // Lưu ảnh vào thư mục upload
                $sliderImage = $request->file('slider_image');
                $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
                // $sliderImage->move(public_path('upload/sliders'), $sliderImageName);
                // Resize và lưu ảnh mới sử dụng Intervention/Image
                Image::make($sliderImage)->resize(2376, 807)->save('upload/sliders/' . $sliderImageName);
                $save_url = 'upload/sliders/' . $sliderImageName;

                Slider::find($slider_id)->update([
                    'slider_title' => $request->slider_title,
                    'short_title' => $request->short_title,
                    'slider_image' => $save_url,
                ]);

                // Redirect hoặc trả về thông báo thành công
                $notification = array(
                    'message' => 'Slider đã được sửa thành công.',
                    'alert-type' => 'success'
                );

                return redirect()->route('all.slider')->with($notification);
            }
        } else {

            if (!$request->hasFile('slider_image')) {
                Slider::findOrFail($slider_id)->update([
                    'slider_title' => $request->input('slider_title'),
                    'short_title' => $request->input('short_title')
                ]);
            }

            $notification = array(
                'message' => 'Slider đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.slider')->with($notification);
        };
    }

    public function DeleteSlider($id)
    {

        $slider = Slider::find($id);
        $img = $slider->slider_image;
        unlink($img);

        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider đã được xóa thành công',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 
}
