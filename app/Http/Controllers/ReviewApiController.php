<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewApiController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|max:191',
            'customer' => 'required|max:191',
            'review' => 'required|max:191',
            'star' => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $review = Review::create([
                'product_id' => $request->input('product_id'),
                'customer' => $request->input('customer'),
                'review' => $request->input('review'),
                'star' => $request->input('star'),
            ]);

            if($review){
                return response()->json([
                    'status' => 200,
                    'message' => 'Review Added Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Somthing Went Wrong'
                ], 500);
            }
        }

    }
}
