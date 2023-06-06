<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class VendorController extends Controller
{
    public function index()
    {
        return view('vendor.index');
    }

    public function VendorLogin()
    {
        return view('vendor.vendor_login');
    }

    public function VendorProfile()
    {
        $users = Auth::user();
        return view('vendor.vendor_profile', compact('users'));
    }

    public function VendorProfileStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[A-Za-z0-9\s]+$/'],
            'email' => ['required', 'email', 'ends_with:@gmail.com'],
            // 'email' => [
            //     'required',
            //     Rule::unique('users')->where(function ($query) {
            //         return $query->where('active', true);
            //     }),
            // ],
            'phone' => ['required', 'digits_between:10,10'],
            'address' => [
                'required',
                'regex:/^(?!.*\/$)[^.|\?!@#$%^&*()+=\]*\[^.|\?!@#$%^&*()+=]*$/',
                'unique:users,address',
            ],
            // Các quy tắc xác thực khác
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.regex' => 'Tên chỉ được chứa chữ cái, số và khoảng trắng.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.ends_with' => 'Địa chỉ email phải chứa định dạng @gmail.com.',
            // 'email.required' => 'Vui lòng nhập địa chỉ email.',
            // 'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits_between' => 'Số điện thoại phải chứa đúng 10 chữ số.',
            'address.required' => 'Vui lòng địa chỉ.',
            'address.regex' => 'Địa chỉ chỉ được chứa chữ cái, số, khoảng trắng và ký tự "/".',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_join = $request->vendor_join;
        $data->vendor_short_info = $request->vendor_short_info;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/vendor_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function VendorDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }
}
