<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Models\Banner;
use App\Models\User;

class BannerController extends Controller
{
    public function AllBanner()
    {
        $bannerData = Banner::all();
        return view('backend.banner.all_banner', compact('bannerData'));
    }

    public function AddBanner()
    {
        return view('backend.banner.add_banner');
    }

    public function StoreBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_title' => [
                'required',
                // 'string',
                'regex:/^[a-zA-Z0-9\s&]+$/',
            ],
            'banner_url' => [
                'required',
                'url',
                // 'regex:/^http:\/\/.*/',
            ],
            'banner_image' => [
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
            'banner_title.required' => 'Vui lòng nhập tên.',
            'banner_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'banner_url.required' => 'Vui lòng nhập đường dẫn banner.',
            'banner_url.url' => 'Đường dẫn banner không hợp lệ.',
            'banner_image.required' => 'Vui lòng nhập ảnh.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Lưu ảnh vào thư mục upload
        $sliderImage = $request->file('banner_image');
        $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
        $sliderImage->move(public_path('upload/banners'), $sliderImageName);
        $save_url = 'upload/banners/' . $sliderImageName;

        Banner::insert([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save_url,
        ]);

        // Redirect hoặc trả về thông báo thành công
        $notification = array(
            'message' => 'Banner đã được thêm thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.banner')->with($notification);
    }

    public function EditBanner($id)
    {
        $bannerData = Banner::find($id);
        return view('backend.banner.edit_banner', compact('bannerData'));
    }

    public function UpdateBanner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'banner_title' => [
                'required',
                // 'string',
                'regex:/^[a-zA-Z0-9\s]+$/',
            ],
            'banner_url' => [
                'required',
                'url',
                // 'regex:/^http:\/\/.*/',
            ],
            // Các quy tắc xác thực khác
        ], [
            'banner_title.required' => 'Vui lòng nhập tên.',
            'banner_title.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'banner_url.required' => 'Vui lòng nhập đường dẫn banner.',
            'banner_url.url' => 'Đường dẫn banner không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $banner_id = $request->id;
        $old_img = $request->old_image;

        if (!empty($old_img)) {

            // Xóa ảnh cũ
            if (file_exists(public_path($old_img))) {
                unlink(public_path($old_img));
            }
        }

        if ($request->file('banner_image')) {
            // Xử lý khi không có lỗi validate
            // Lưu ảnh vào thư mục upload
            $sliderImage = $request->file('banner_image');
            $sliderImageName = time() . '.' . $sliderImage->getClientOriginalExtension();
            Image::make($sliderImage)->resize(2376, 807)->save('upload/banners/' . $sliderImageName);
            $save_url = 'upload/banners/' . $sliderImageName;

            Banner::findOrFail($banner_id)->update([
                'banner_title' => $request->banner_title,
                'banner_url' => $request->banner_url,
                'banner_image' => $save_url,
            ]);

            // Redirect hoặc trả về thông báo thành công
            $notification = array(
                'message' => 'Banner đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        } else {

            if (!$request->hasFile('banner_image')) {
                Banner::findOrFail($banner_id)->update([
                    'banner_title' => $request->banner_title,
                    'banner_url' => $request->banner_url,
                ]);
            }

            $notification = array(
                'message' => 'Banner đã được sửa thành công.',
                'alert-type' => 'success'
            );

            return redirect()->route('all.banner')->with($notification);
        }
    }

    public function DeleteBanner($id)
    {
        $banner = Banner::findOrFail($id);

        $image_path = public_path($banner->banner_image);

        if (File::exists($image_path)) {
            unlink($image_path);
        }

        $banner->delete();

        $notification = array(
            'message' => 'Banner đã được xóa thành công.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.banner')->with($notification);
    }
}
