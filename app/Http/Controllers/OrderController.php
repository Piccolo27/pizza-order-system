<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //order list page
    public function orderList(){
        $orders = Order::select('orders.*','users.name as user_name')
                    ->leftJoin('users','users.id','orders.user_id')
                    ->orderBy('created_at','desc')
                    ->get();
        return view('admin.order.list',compact('orders'));
    }

    //sort with ajax
    public function changeStatus(Request $request){
        $request->status = $request->status == null ? "" : $request->status ;

        $orders = Order::select('orders.*','users.name as user_name')
                    ->leftJoin('users','users.id','orders.user_id')
                    ->orderBy('created_at','desc');

        if($request->orderStatus == null){
            $orders = $orders->get();
        }else{
            $orders = $orders->where('orders.status',$request->orderStatus)->get();
        }
        return view('admin.order.list',compact('orders'));
    }

    //ajax change status
    public function ajaxChangeStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status' => $request->status ,
        ]);

        $orders = Order::select('orders.*','users.name as user_name')
                    ->leftJoin('users','users.id','orders.user_id')
                    ->orderBy('created_at','desc')
                    ->get();

        return response()->json($orders,200);
    }

    //order list
    public function listInfo($orderCode){
        $orders = Order::where('order_code',$orderCode)->first();
        $orderLists = OrderList::select('order_lists.*','users.name as user_name','products.image as product_image', 'products.name as product_name')
                            ->leftJoin('users','users.id','order_lists.user_id')
                            ->leftJoin('products','products.id','order_lists.product_id')
                            ->where('order_code',$orderCode)
                            ->get();
        return view('admin.order.productList',compact('orderLists','orders'));
    }
}
