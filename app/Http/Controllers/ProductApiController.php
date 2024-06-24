<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    public function index(){

        $products =  Product::all();
        return ProductCollection::collection($products);

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'details' => 'required|max:191',
            'price' => 'required|max:191',
            'stock' => 'required|max:191',
            'discount' => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $product = Product::create([
                'name' => $request->input('name'),
                'details' => $request->input('details'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'discount' => $request->input('discount'),
            ]);

            if($product){
                return response()->json([
                    'status' => 200,
                    'message' => 'Product Added Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Somthing Went Wrong'
                ], 500);
            }
        }

    }

    public function showById($id){
        $products =  Product::find($id);
        if($products){
            return new ProductResource($products);
        }else{
            return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }

    public function update($id){
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'discount' => 'required',
        ]);

        $product =  Product::find($id);
        if($product){

            $product->name = request('name');
            $product->details = request('details');
            $product->price = request('price');
            $product->stock = request('stock');
            $product->discount = request('discount');
            $product->save();

            return new ProductResource($product);
        }else{
            return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }
    public function destroy($id){
        $product =  Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product Deleted Successfully'
            ], 200);
            //return new ProductResource($product);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No User ID Found',
            ], 404);
            //return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }
}
