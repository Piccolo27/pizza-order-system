<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get all product list
    public function allDataList(){
        $users = User::get();
        $products = Product::get();
        $categories = Category::get();
        $orders = Order::get();
        $orderLists = OrderList::get();
        $contacts = Contact::get();

        $data = [
            'user' => $users ,
            'product' => $products ,
            'category' => $categories ,
            'order' => $orders ,
            'order_list' => $orderLists ,
            'contact' => $contacts
        ];

        return response()->json($data, 200);
    }

    //post
    public function categoryCreate(Request $request){
        $data = [
        'name' => $request->name,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
        ];

        $response = Category::create($data);
        return $response;
    }

    //create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);
        $contact = Contact::get();
        return response()->json($contact, 200);
    }

    //delete category
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(["status" => true , "message" => "Delete Success" , "deleteData" => $data], 200);
        }

        return response()->json(["status" => false , "message" => "there is no same id"], 200);
    }

    //category details
    public function categoryDetails(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            return response()->json(["status" => true , "category" => $data], 200);
        }

        return response()->json(["status" => false , "message" => "there is no category"], 500);
    }

    //update category
    public function categoryUpdate(Request $request){
        $categoryId = $request->category_id;
        $dbSource = Category::where('id',$categoryId)->first();

        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            $response = Category::where('id',$categoryId)->update($data);
            return response()->json(["status" => true , "message" => "category update success..." , 'category' => $response], 200);
        }

        return response()->json(["status" => false , "message" => "there is no category for update"], 500);


    }

    //get contact data
    private function getContactData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'subject' => $request->subject ,
            'message' => $request->message ,
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now()
        ];
    }

    //get category data
    private function getCategoryData($request){
        return [
            'name' => $request->category_name ,
            'updated_at' =>carbon::now()
        ];
    }
}
