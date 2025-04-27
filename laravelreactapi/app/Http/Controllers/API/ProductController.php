<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'category_id' => 'required | max:191',
            'meta_title' => 'required | max:191',
            'name' => 'required | max:191',
            'slug' => 'required|max:191',
            'brand' => 'required | max:20',
            'selling_price' => 'required | max:20',
            'original_price' => 'required | max:20',
            'qty' => 'required | max:4',
            'image' => 'required | mimes:jpg,jpeg,png,gif,svg | max:2048',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $Validator->messages(),
            ]);
        } else {
            $product = new Product();
            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');

            $product->meta_title = $request->input('meta_title');
            $product->meta_keyword = $request->input('meta_keyword');
            $product->meta_descrip = $request->input('meta_descrip');

            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qty = $request->input('qty');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->image = 'uploads/product/' . $filename;
            }

            $product->featured = $request->input('featured') == true ? '1' : '0';
            $product->popular = $request->input('popular') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';
            $product->save();
        }

        return response()->json([
            'status' => 200,
            'message' => "Product added successfully",
        ]);

    }
    


    public function edit($id)
    {
        $product = Product::find($id);
    
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product ID Found',
            ]);
        }
    }



    public function update(Request $request, $id)
    {
        $Validator = Validator::make($request->all(), [
            'category_id' => 'required | max:191',
            'meta_title' => 'required | max:191',
            'name' => 'required | max:191',
            'slug' => 'required|max:191',
            'brand' => 'required | max:20',
            'selling_price' => 'required | max:20',
            'original_price' => 'required | max:20',
            'qty' => 'required | max:4',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $Validator->messages(),
            ]);
        } else {
            $product = Product::find($id);
            if ($product) {
                $product->category_id = $request->input('category_id');
                $product->meta_title = $request->input('meta_title');
                $product->meta_descrip = $request->input('meta_descrip');
                $product->meta_keyword = $request->input('meta_keyword');
                $product->name = $request->input('name');
                $product->slug = $request->input('slug');
                $product->brand = $request->input('brand');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->qty = $request->input('qty');
                $product->description = $request->input('description');
            

                if ($request->hasFile('image')) {
                    $destination = public_path('uploads/products/' . $product->image);
                    if (File::exists($destination)) {
                        File::delete($destination);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/products/', $filename);
                    $product->image = $filename;
                }

                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Product ID Found',
                ]);
            }
        }
    }
    
}
