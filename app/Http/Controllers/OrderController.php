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
use App\Order;

class OrderController extends Controller
{
    /*
    * order index page
    */
    public function index(Request $request)
    {
        $user = $request->session()->get('user');

        $orders = Order::select('orders.*', 'products.name', 'products.image', 'users.name')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->leftJoin('products', 'products.id', '=', 'orders.product_id')
        ->where('orders.user_id', $user->id)
        ->paginate(6);

    	return view::make('orders')->with([ 'orders'=> $orders]);
    }

    /**
    * make order page
    */
    public function requestOrderPage(Request $request, $productId)
    {
        $product = Product::find($productId);
        if(empty($product)){
            $error = Session::flash('error', 'Failed to make order.');
            return redirect()->back()->with($error);
        }

        return view::make('make_order')->with(['product'=> $product]);
    }

    /**
    * store customer order
    */
    public function store(Request $request, $productId)
    {
        try{

            $rules = [
                'quantity'=> 'required',
                'address'=> 'required',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $product = Product::find($productId);

            if($product->unit < $request->quantity){
                $error = Session::flash('error', 'Failed! Quantity is more than available unit.');
    
                return redirect()->back()->with($error);
            }


            $amount = $request->quantity * $product->price;
    
            $user = $request->session()->get('user');
            
            // get 
            $order = Order::create([
                'product_id' => $productId,
                'user_id' => $user->id,
                'quantity' => $request->quantity,
                'address' => $request->address,
                'amount' => $amount
            ]);
            
            // update product unit
            Product::find($productId)->update([
                'unit'=> ($product->unit - $request->quantity)
            ]);

            if($order){
    
                $success = Session::flash('success', 'Order created successfully.');
    
                return redirect()->to('/')->with($success);
            }else {
                # code...
                $error = Session::flash('error', 'Failed to create order.');
    
                return redirect()->to('/')->with($error);
            }
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * update delivery status
    */
    public function deliverOrder(Request $request, $id)
    {
        try{

            Order::find($id)->update([
                'is_delivered'=>'1'
            ]);
            
            $success = Session::flash('success', 'Order delivery status updated successfully.');
            return redirect()->back()->with($success);
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * show all orders
    */
    public function show()
    {
        $orders = Order::select('orders.*', 'products.name', 'products.image', 'users.name')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->leftJoin('products', 'products.id', '=', 'orders.product_id')
        ->paginate(6);

        return view::make('/manage_orders')->with([ 'orders'=> $orders]);
    }

    /**
    * delete order
    */
    public function deleteOrder(Request $request, $id)
    {
        $delete = Order::find($id)->delete();

        if($delete){
            $success = Session::flash('success', 'Order deleted successfully.');

            return redirect()->to('/manage/orders')->with($success);
        }

        $error = Session::flash('error', 'Failed to delete order.');

        return redirect()->to('/manage/orders')->with($error);
    }
}
