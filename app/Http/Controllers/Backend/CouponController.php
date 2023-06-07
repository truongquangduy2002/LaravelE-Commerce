<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoucherEmail;

class CouponController extends Controller
{
    public function AllCoupon()
    {
        $coupon = Coupon::latest()->get();
        return view('backend.coupon.all_coupon', compact('coupon'));
    }

    public function AddCoupon()
    {
        return view('backend.coupon.add_coupon');
    }

    public function StoreCoupon(Request $request)
    {

        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.coupon')->with($notification);
    } // End Method 


    public function EditCoupon($id)
    {

        $coupon = Coupon::findOrFail($id);
        return view('backend.coupon.edit_coupon', compact('coupon'));
    } // End Method 


    public function UpdateCoupon(Request $request)
    {

        $coupon_id = $request->id;

        Coupon::findOrFail($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.coupon')->with($notification);
    } // End Method 

    public function DeleteCoupon($id)
    {

        Coupon::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function showSendCoupon()
    {
        $users = User::where('role', 'user')->get(); // Lấy danh sách người dùng
        $coupons = Coupon::all(); // Lấy danh sách xoupon

        return view('backend.coupon.send_user_coupon', compact('users', 'coupons'));
    }

    public function sendCoupon(Request $request)
    {
        $userId = $request->input('name');
        $couponName = $request->input('coupon_name');

        $user = User::find($userId);
        $coupon = Coupon::find($couponName);

        if ($user && $coupon && $user->role === 'user') {
            // Gửi coupon cho người dùng chỉ khi người dùng có vai trò là "user"

            // Gửi email thông báo
            Mail::to($user->email)->send(new VoucherEmail($user, $coupon));

            // Logic để gửi coupon cho người dùng
            return redirect()->route('admin.send.coupon')->with('success', 'Coupon đã được gửi thành công.');
        }

        return redirect()->route('admin.send.coupon')->with('error', 'Không thể gửi coupon cho người dùng này.');
    }
}
