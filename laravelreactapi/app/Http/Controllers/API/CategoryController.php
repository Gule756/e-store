<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;



class CategoryController extends Controller
{


    public function allcategory(Request $request): JsonResponse
    {
        $categories = Category::all(); // Or however you want to fetch your categories

        return response()->json([
            'status' => 200,
            'category' => $categories,
        ]);
    }
    public function index(Request $request)
    {
        $Category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $Category,
        ]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Category ID Found',
            ]);
        }
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'meta_title' => 'required | max:191',
            'name' => 'required | max:191',
            'slug' => 'required|max:191',
        ]);
        if ($Validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $Validator->messages(),
            ]);
        }

        $category = new Category();
        $category->meta_title = $request->Input('meta_title');
        $category->meta_descrip = $request->Input('meta_descrip');
        $category->meta_keyword = $request->Input('meta_keyword');
        $category->name = $request->Input('name');
        $category->slug = $request->Input('slug');
        $category->description = $request->Input('description');
        $category->status = $request->Input('status') == true ? '1' : '0';
        $category->save();
        return response()->json([
            'status' => 200,
            'message' => 'Category Added Successfully',
        ]);
    }


    public function update(Request $request, $id)
    {
        $Validator = Validator::make($request->all(), [
            'meta_title' => 'required | max:191',
            'name' => 'required | max:191',
            'slug' => 'required|max:191',
        ]);
        if ($Validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $Validator->messages(),
            ]);
        } else {
            $category = Category::find($id);
            if ($category) {
                $category->meta_title = $request->Input('meta_title');
                $category->meta_descrip = $request->Input('meta_descrip');
                $category->meta_keyword = $request->Input('meta_keyword');
                $category->name = $request->Input('name');
                $category->slug = $request->Input('slug');
                $category->description = $request->Input('description');
                $category->status = $request->Input('status') == true ? '1' : '0';
                $category->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Category ID Found',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Category ID Found',
            ]);
        }
    }



}