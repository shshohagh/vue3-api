<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{

    public function index(){

        return ProductCollection::collection(Product::paginate(10));

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'price' => 'required|max:191',
            'stock' => 'required|max:191',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);

        }else{

            $product = Product::create([
                'name' => $request->input('name'),
                'details' => $request->input('details')??'N/A',
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'discount' => $request->input('discount')??0,
            ]);

            if($product){

                return response()->json([
                    'status' => 200,
                    'message' => 'Data Added Successfully'
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

            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found!',
            ], 404);

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

            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found!',
            ], 404);

        }
    }

    public function destroy($id){

        $product =  Product::find($id);

        if($product){

            $product->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data Deleted Successfully'
            ], 200);

        }else{

            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found!',
            ], 404);

        }
    }
    
}
