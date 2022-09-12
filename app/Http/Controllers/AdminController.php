<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
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

    //direct admin details
    public function details(){
        return view('admin.account.details');
    }

    //direct admin profile page
    public function edit(){
        return view('admin.account.edit');
    }

    //update account
    public function update(Request $request,$id){
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
        return redirect()->route('admin#details')->with(['updateSuccess' => 'Admin Account Updated']);
    }

    //admin list
    public function list(){
        $admins = user::when(request('key'),function($query){
                        $query->orWhere('name','like','%'.request('key').'%')
                              ->orWhere('email','like','%'.request('key').'%')
                              ->orWhere('gender','like','%'.request('key').'%')
                              ->orWhere('phone','like','%'.request('key').'%')
                              ->orWhere('address','like','%'.request('key').'%');
                    })
                    ->where('role','admin')
                    ->paginate(3);
        $admins->appends(request()->all());
        return view('admin.account.list',compact('admins'));
    }

    //delete admin
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Admin Account Delected...']);
    }

    //ajax change role
    public function ajaxChangeRole(Request $request){
        User::where('id',$request->adminId)->update([
            'role' => $request->role ,
        ]);
    }

    //request user data
    private function requestUserData($request){
        return [
            'role' => $request->role,
        ];
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
