<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\User;

class IndexController extends Controller
{
    public function ProductDetail($id, $slug)
    {
        $product = Product::findOrFail($id);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $multiImage = MultiImg::where('product_id', $id)->get();

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id', $cat_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(4)->get();

        return view('frontend.product.product_detail', compact('product', 'product_color', 'product_size', 'multiImage', 'relatedProduct'));
    }


    public function AllVendor()
    {
        $vendors = User::where('status', 'active')->where('role', 'vendor')->orderBy('id', 'DESC')->get();
        return view('frontend.vendor.all_vendor', compact('vendors'));
    }

    public function ProductViewAjax($id)
    {

        $product = Product::with('category', 'brand', 'vendor')->findOrFail($id);
        // $color = $product->product_color;
        // $product_color = explode(',', $color);

        // $size = $product->product_size;
        // $product_size = explode(',', $size);

        return response()->json(array(

            'product' => $product,
            // 'color' => $product_color,
            // 'size' => $product_size,

        ));
    } // End Method 

    public function ProductSearch(Request $request)
    {

        $request->validate(['search' => "required"]);

        $item = $request->search;
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $products = Product::where('product_name', 'LIKE', "%$item%")->get();
        $newProduct = Product::orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.product.search', compact('products', 'item', 'categories', 'newProduct'));
    } // End Method 

    public function SearchProduct(Request $request)
    {

        $request->validate(['search' => "required"]);

        $item = $request->search;
        $products = Product::where('product_name', 'LIKE', "%$item%")->select('product_name', 'product_slug', 'product_thambnail', 'selling_price', 'id')->limit(6)->get();

        return view('frontend.product.search_product', compact('products'));
    } // End Method 
}
