<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\MultiImg;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    public  function AllProduct()
    {
        $products = Product::all();
        return view('backend.product.all_product', compact('products'));
    }

    public function AddProduct()
    {
        $activeVendor = User::where('status', 'active')->where('role', 'vendor')->latest()->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('backend.product.add_product', compact('activeVendor', 'brands', 'categories'));
    }

    public function StoreProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s,&]+$/',
            ],
            // 'product_tags' => [
            //     'regex:/^[a-zA-Z0-9\s]+$/',
            // ],
            // 'product_size' => [
            //     'regex:/^[a-zA-Z0-9\s]+$/',
            // ],
            // 'product_color' => [
            //     'regex:/^[a-zA-Z0-9\s]+$/',
            // ],
            'selling_price' => [
                'required', 'numeric', 'regex:/^[0-9.]+$/'
            ],
            'discount_price' => [
                'required', 'numeric', 'regex:/^[0-9.]+$/'
            ],
            'product_code' => [
                'required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/'
            ],
            'product_qty' => [
                'required', 'numeric', 'regex:/^[0-9]+$/'
            ],
            'product_thambnail' => [
                'required',
                'image',
            ],
            'multi_img' => [
                'required',
            ],
            // Các quy tắc xác thực khác
        ], [
            'product_name.required' => 'Vui lòng nhập tên.',
            'product_name.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            // 'product_tags.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            // 'product_size.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            // 'product_color.regex' => 'Chuỗi không được chứa ký tự đặc biệt.',
            'selling_price.required' => 'Vui lòng nhập số tiền.',
            'selling_price.regex' => 'Selling Price không hợp lệ.',
            'discount_price.required' => 'Vui lòng nhập số tiền.',
            'discount_price.regex' => 'Discount Price không hợp lệ.',
            'product_code.regex' => 'Product Code không hợp lệ.',
            'product_qty.regex' => 'Product Quantity không hợp lệ.',
            'product_thambnail.required' => 'Vui lòng chọn ảnh.',
            'multi_img.required' => 'Vui lòng chọn ảnh.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(800, 800)->save('upload/products/thambnail/' . $name_gen);
        $save_url = 'upload/products/thambnail/' . $name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thambnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        /// Multiple Image Upload From her //////

        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(800, 800)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;


            MultiImg::insert([

                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);
        } // end foreach

        /// End Multiple Image Upload From her //////

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    }

    public function ProductStock()
    {

        $products = Product::latest()->get();
        return view('backend.product.product_stock', compact('products'));
    } // End Method 
}
