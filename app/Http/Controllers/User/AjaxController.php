<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    //ajax
    public function pizzaList(Request $request){
        //logger($request->status);
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        }else{
            $data = Product::orderBy('created_at','asc')->get();
        }
        return response()->json($data, 200);
    }

    //return pizza list
    public function addToCart(Request $request){
        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            'message' => 'Add to cart completed',
            'status' => 'success'
        ];
        return response()->json($response, 200);
    }

    //get order data
    private function getOrderData($request){
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'quantity' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
