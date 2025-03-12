<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // This method will show product page
    public function index(){
        $products = Product::orderBy('created_at','DESC')->get();
        return view('products.list',[
            'products' => $products
        ]);
    }
    // This method will show create product page
    public function create(){
        return view('products.create');
    }
    // This method will store a product in db
    public function store(Request $request){
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->hasFile('image') && $request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        // store the product in db
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->hasFile('image')) {
            // store image
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;   // Unique image name

            // Save the image to the public/uploads/products directory
            $image->move(public_path('uploads/products'), $imageName);

            // Save image path to the database (relative path)
            $product->image = 'uploads/products/' . $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    // This method will show edit product page
    public function edit($id){
        // echo $id;
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }
    // This method will show update product
    public function update($id, Request $request){
        $product = Product::findOrFail($id);
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->hasFile('image') && $request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }

        // update the product in db
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->hasFile('image')) {
            // Construct the full path for the old image
            $oldImagePath = public_path($product->image);

            // Debug: Print the old image path
            // dd($oldImagePath);

            // Check if file exists and delete it
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            
            // store the new image
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;   // Unique image name

            // Save the image to the public/uploads/products directory
            $image->move(public_path('uploads/products'), $imageName);

            // Save image path to the database (relative path)
            $product->image = 'uploads/products/' . $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    // This method will delete a product
    public function destroy($id){
        $product = Product::findOrFail($id);

        // delete image
        // Construct the full path for the old image
        $oldImagePath = public_path($product->image);

        // Debug: Print the old image path
        // dd($oldImagePath);

        // Check if file exists and delete it
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }
        // delete product from database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
