<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home page
    public function home(){
        $pizzas = Product::orderBy('created_at','desc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzas','categories','cart'));
    }

    //change password page
    public function changePasswordPage(){
        return view('user.password.change');
    }

    //change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password; //hash value

        if (Hash::check($request->oldPassword, $dbHashValue)){

            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            Auth::logout();
            return redirect()->route('auth#loginPage')->with(['changeSuccess' => 'Password is changed successfully.']);
        }

        return back()->with(['notMatch' => 'The old password not match. Try again!']);
    }

    //user account change page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    //user acc change
    public function accountChange(Request $request, $id){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if ($request->hasFile('image')){
            $oldImage = User::where('id',$id)->first()->image;

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;

            if ($oldImage != null){
                Storage::delete('public/'.$oldImage);
            }

        }

        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess' => 'User Account Updated']);
    }

    //filter pizza
    public function filter($categoryId){
        $pizzas = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $categories = Category::get();
        return view('user.main.home',compact('pizzas','categories'));
    }

    //pizza details
    public function pizzaDetails($pizzaId){
        $pizzas = Product::where('id',$pizzaId)->first();
        $pizzaLists = Product::get();
        return view('user.main.details',compact('pizzas','pizzaLists'));
    }

    //cart list
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as pizza_image')
                        ->leftJoin('products','products.id','carts.product_id')
                        ->where('user_id',Auth::user()->id)
                        ->get();

        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->quantity;
        }
        //dd($totalPrice);
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    //request user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'gender' => $request->gender ,
            'address' => $request->address ,
            'updated_at' => Carbon::now() ,
        ];
    }

    //account validation check
    private function accountValidationCheck($request) {
        Validator::make($request->all(),[
            'name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'gender' => 'required' ,
            'image' => 'mimes:png,jpg,jpeg|file',
            'address' => 'required' ,
        ])->validate();
    }

    //password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
}
