<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function addproduct() {
        $categories = Category::All()->pluck('category_name', 'category_name');

        return view('admin.addproduct')->with('categories', $categories);
    }

    public function products() {
        $products = Product::All();

        return view('admin.products')->with('products', $products);
    }

    public function saveproduct(Request $request) {
        $this->validate($request, ['product_name' => 'required',
                                   'product_price' => 'required',
                                   'detail' => 'required',
                                   'product_category' => 'required',
                                   'product_image' => 'image|nullable|max:3072']);

        if($request->hasFile('product_image')) {
            // 1: get the file name with extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just file extension
            $fileExt = $request->file('product_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

            //Upload Image
            $imagePath = $request->file('product_image')->storeAs('public/product_image', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $product = new Product();
        
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->detail = $request->detail;
        $product->product_category = $request->product_category;
        $product->product_image = $fileNameToStore;
        $product->status = 1;

        $product->save();

        return back()->with('status', 'The product has been successfully saved..!!');
    }

    public function edit_product($id) {
        $product = Product::find($id);

        $categories = Category::All()->pluck('category_name', 'category_name');

        return view('admin.edit_product')->with('product', $product)->with('categories', $categories);
    }

    public function updateproduct(Request $request) {
        $this->validate($request, ['product_name' => 'required',
                                   'product_price' => 'required',
                                   'detail' => 'required',
                                   'product_category' => 'required',
                                   'product_image' => 'image|nullable|max:3072']);

        $product = Product::find($request->id);
        
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->detail = $request->detail;
        $product->product_category = $request->product_category;

        if($request->hasFile('product_image')) {
            // 1: get the file name with extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3: get just file extension
            $fileExt = $request->file('product_image')->getClientOriginalExtension();
            // 4: file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;

            //Upload Image
            $imagePath = $request->file('product_image')->storeAs('public/product_image', $fileNameToStore);

            if($product->product_image != 'noimage.jpg') {
                Storage::delete('product_image/'.$product->product_image);
            }

            $product->product_image = $fileNameToStore;
        }

        $product->update();

        return redirect('/products')->with('status', 'The product has been successfully Updated..!!');
    }

    public function delete_product($id) {
        $product = Product::find($id);

        if($product->product_image != 'noimage.jpg') {
            Storage::delete('public/product_image/'.$product->product_image);
        }

        $product->delete();

        return back()->with('status', 'The product has been successfully deleted..!!');
    }

    public function activate_product($id) {
        $product = Product::find($id);

        $product->status = 1;
        $product->update();

        return back()->with('status', 'The product has been successfully activated..!!');
    }

    public function product_detail($id) {
        $product = Product::find($id);

        return view('client.product_detail')->with('product', $product);
    }

    public function unactivate_product($id) {
        $product = Product::find($id);

        $product->status = 0;
        $product->update();

        return back()->with('status', 'The product has been successfully unactivated..!!');
    }

    public function view_product_by_category($category_name) {
        $products = Product::All()->where('product_category', $category_name)->where('status', 1);
        $categories = Category::All();

        return view('client.shop')->with('products', $products)->with('categories', $categories);
    }
}
