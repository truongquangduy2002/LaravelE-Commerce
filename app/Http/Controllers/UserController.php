<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Dashboard()
    {
        $userData = Auth::user();
        return view('index', compact('userData'));
    }

    public function index()
    {
        return view('frontend.index');
    }

    public function UserProfileStore(Request $request)
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
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function UserChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => [
                'required',
                'string',
                'regex:/^\S*$/',
                'regex:/^[A-Za-z0-9]+$/',
            ],
            'new_password' => [
                'required',
                'string',
                'regex:/^\S*$/',
                'regex:/^[A-Za-z0-9]+$/',
            ],
            'confirm_password' => ['required_with:new_password|same:new_password', 'regex:/^[A-Za-z0-9\s]+$/'],
            // Các quy tắc xác thực khác
        ], [
            'old_password.regex' => 'The password may only contain letters and numbers.',
            'new_password.regex' => 'The password may only contain letters and numbers.',
            'cofirm_password.regex' => 'The confirmation password does not match.',
            'confirm_password.required_with' => 'Xác nhận mật khẩu không trùng khớp.',
        ]);

        //Match The Old Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");
        }

        //Update The New Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function UserDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard');
    }
}
