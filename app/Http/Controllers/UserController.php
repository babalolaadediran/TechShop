<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Hash;
use View;
use Session;
use Redirect;
use Validator;
use App\User;
use App\Product;

class UserController extends Controller
{
    /**
    * index page
    */
    public function index()
    {
        $products= Product::paginate(6);
        return view::make('index')->with(['products'=> $products]);
    }

    /**
     * register user
     */
    public function registerUser(Request $request)
    {
        try{
            // set validation rules
            $rules = [

                'name'=> 'required',
                'email'=> 'required|email',
                'password'=> 'required',
                'confirm_password'=> 'required|same:password'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
            }

            # collect data
            $name = $request->name;
            $email = $request->email;
            $password = Hash::make($request->password);

            // validate to check if email exist
            $validateEmail = User::where('email', $email)->first();

            if($validateEmail){
                $error = Session::flash('error', 'Email already exist.');

                return redirect()->back()->with($error);
            }

            // register user
            $register = User::create([
                'name'=>$name,
                'email'=> $email,
                'password'=> $password
            ]);

            if($register){
                $success = Session::flash('success', 'Registration Successful');
                return redirect()->to('/login')->with($success);
            }

            $error = Session::flash('error', 'Registration Successful');
            return redirect()->back()->with($error);
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());

            return redirect()->back()->with($error);
        }
    }

    /**
     * Login user 
     */
    public function loginUser(Request $request)
    {
        try{
            // set validation rules
            $rules = [
                'email'=> 'required|email',
                'password'=> 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
            }

            // collect data
            $email  = $request->email;
            $password = $request->password;

            //check if user exist
            $validateUser = User::where('email', $email)->first();

            if(empty($validateUser)){
                $error = Session::flash('error', 'Invalid login credentials.');
                return redirect()->back()->withInput()->with($error);
            }

            // validate password
            $passwordCheck  = Hash::check($password, $validateUser->password);

            if(!$passwordCheck){
                $error = Session::flash('error', 'Invalid login credentials.');
                return redirect()->back()->withInput()->with($error);
            }

            $storeUser = Session::put('user', $validateUser);
            return redirect()->to('/')->with($storeUser);
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());

            return redirect()->back()->with($error);
        }
    }

    /**
     * Logout 
    */
    public function logout(Request $request) {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->to('/');
    }
}
