<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\ConfirmPassword;
use App\Notifications\VendorApproveNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminStore(Request $request)
    {

        $request->validate([
            'email' => 'require',
            'password' => 'require|max:6'
        ]);

        // Xử lý xác thực đăng nhập
        if (!auth()->attempt($request->only('email', 'password'))) {
            // Xử lý lỗi đăng nhập
            Session::flash('error', 'Thông tin đăng nhập không hợp lệ.');

            return redirect()->route('login')->withInput();
        }
    }

    public function AdminProfile()
    {
        // $id = Auth::user();
        $users = Auth::user();
        return view('admin.admin_profile', compact('users'));
    }

    public function AdminProfileStore(Request $request)
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


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    }

    public function AdminPasswordUpdate(Request $request)
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

        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if ($new_password !== $confirm_password) {
            return redirect()->back()->withErrors(['error' => 'Mật khẩu xác nhận không khớp!']);
        }

        if ($validator->fails()) {
            // Xử lý lỗi
            $errors = $validator->errors();
            // Lấy thông báo lỗi khi trường "new_password" không trùng khớp
            $confirmPasswordError = $errors->first('confirm_password');

            // Xử lý thông báo lỗi tùy ý
            if ($confirmPasswordError) {
                // Thực hiện hành động khi trường "new_password_confirmation" không trùng khớp
                // Ví dụ: Gán thông báo lỗi vào biến flash để hiển thị cho người dùng
                session()->flash('error', $confirmPasswordError);
            } else {
                // Xử lý các lỗi khác nếu có
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

    //InActive Vendor
    public function InActiveVendor()
    {
        $inActiveVendor = User::where('status', 'inactive')->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor', compact('inActiveVendor'));
    }

    //Active Vendor
    public function ActiveVendor()
    {
        $activeVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.active_vendor', compact('activeVendor'));
    }

    //InActive Vendor Detail
    public function InActiveVendorDetail($id)
    {
        $inactiveVendorDetails = User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_detail', compact('inactiveVendorDetails'));
    }

    // Vendor Active Approve
    public function ActiveVendorApprove(Request $request)
    {
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id);
        $user->status = 'active';
        $user->save();

        $notification = array(
            'message' => 'Vendor Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.active.vendor')->with($notification);
    }

    //Active Vendor Detail
    public function ActiveVendorDetail($id)
    {
        $activeVendorDetails = User::findOrFail($id);
        return view('backend.vendor.active_vendor_detail', compact('activeVendorDetails'));
    }

    // Vendor InActive Approve
    public function InActiveVendorApprove(Request $request)
    {
        $vendor_id = $request->id;
        $user = User::findOrFail($vendor_id);
        $user->status = 'inactive';
        $user->save();

        $notification = array(
            'message' => 'Vendor InActive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.inactive.vendor')->with($notification);
    }

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    ///////////// Admin All Method //////////////


    public function AllAdmin()
    {
        $alladminuser = User::where('role', 'admin')->latest()->get();
        return view('backend.admin.all_admin', compact('alladminuser'));
    } // End Mehtod 

    public function AddAdmin()
    {
        $roles = Role::all();
        return view('backend.admin.add_admin', compact('roles'));
    } // End Mehtod 

    public function AdminUserStore(Request $request)
    {

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    } // End Mehtod 

    public function EditAdminRole($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.admin.edit_admin', compact('user', 'roles'));
    } // End Mehtod 


    public function AdminUserUpdate(Request $request, $id)
    {


        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);
    } // End Mehtod 

    public function DeleteAdminRole($id)
    {

        $user = User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Mehtod 

}
