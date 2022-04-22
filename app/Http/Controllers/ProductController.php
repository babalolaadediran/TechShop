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
use App\Category;

class ProductController extends Controller
{
    /**
    * store product
    */
    public function store(Request $request)
    {
    	try{
    		$rules = [
    			'image'=> 'required|image|mimes:jpg,jpeg,png',
    			'name'=>'required',
    			'description'=> 'required',
    			'unit'=> 'required',
    			'price'=> 'required',
                'cat_id'=> 'required'
    		];

    		$validator = Validator::make($request->all(), $rules);

    		if($validator->fails()){
                dd($validator);
    			return redirect()->back()->withInput()->withErrors($validator);
    		}

    		// collect data
    		$image = $request->file('image');
			$image_name = time().'_'.$image->getClientOriginalName();
			$image_url = 'uploads/'.$image_name;

    		$name = strtolower($request->name);
    		$description = $request->description;
    		$unit = $request->unit;
    		$price = $request->price;
            $cat_id = $request->cat_id;


    		// validate if product already exist.
    		$validateProduct = Product::where('name', $name)->first();

    		if($validateProduct){
    			$error = Session::flash('error', 'Product already exist.');
	    		return redirect()->back()->withInput()->with($error);
    		}

    		// create product record
    		Product::create([
    			'image'=> $image_url,
    			'name'=>$name,
    			'description'=>$description,
    			'unit'=>$unit,
    			'price'=>$price,
                'cat_id'=>$cat_id
    		]);

    		// move image
    		$image->move('uploads', $image_name);

    		// return success message
    		$success = Session::flash('success', 'Product Added successfully.');
    		return redirect()->back()->with($success);
    	}catch(\Exception $ex){
    		$error = Session::flash('error', $ex->getMessage());
    		return redirect()->back()->with($error);
    	}
    }

    /*
    * edit product
    */
    public function edit(Request $request, $productId)
    {
        try{

            // check if product exist
            $getProductDeatils = Product::where('id', $productId)->first();

            if(!$getProductDeatils){
                $error = Session::flash('error', 'Record not found.');
                return redirect()->back()->with($error);
            }

            // return record
            return view::make('edit_product')->with(['getProductDeatils'=> $getProductDeatils]);
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * update product
    */
    public function updateProduct(Request $request, $productId)
    {
        try{

           $rules = [
                'name'=>'required',
                'description'=> 'required',
                'unit'=> 'required',
                'price'=> 'required',
                'cat_id'=> 'required'
           ];

           $validator = Validator::make($request->all(), $rules);

           if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
           }

            // get product details
            $productDetails = Product::find($productId);

            // collect data
            $name = strtolower($request->name);
            $description = $request->description;
            $unit = $request->unit;
            $price = $request->price;
            $cat_id = $request->cat_id;

            if($request->hasFile('image')){
                $imageRule = [
                    'image'=> 'required|image|mimes:jpg,jpeg,png'
                ];

                $imageValidator = Validator::make($request->all(), $imageRule);

                if($imageValidator->fails()){
                    return redirect()->back()->withInput()->withErrors($validator);
                }

                // collect
                $image = $request->file('image');
                $image_name = time().'_'.$image->getClientOriginalName();
                $image_url = 'uploads/'.$image_name;

                // delete previous product image
                if(unlink($productDetails->image)){
                    // update product record
                    $update = Product::find($productId)->update([
                        'image'=> $image_url,
                        'name'=>$name,
                        'description'=>$description,
                        'unit'=>$unit,
                        'price'=>$price,
                        'cat_id'=>$cat_id
                    ]);

                    // move image
                    $image->move('uploads', $image_name);

                    $success = Session::flash('success', 'Product details updated successfully.');
                    return redirect()->to('/')->with($success);
                }
            }

            $update = Product::find($productId)->update([
                'name'=>$name,
                'description'=>$description,
                'unit'=>$unit,
                'price'=>$price,
                'cat_id'=>$cat_id
            ]);

            $success = Session::flash('success', 'Product details updated successfully.');
            return redirect()->to('/')->with($success);

        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * delete product
    */
    public function deleteProduct(Request $request, $productId)
    {
        // check for product
        $validateProduct = Product::find($productId);

        if(!$validateProduct){
            $error = Session::flash('error', 'Failed to delete product record.');
            return redirect()->to('/')->with($error);
        }

        // delete product
        $validateProduct->delete();

        $success = Session::flash('success', 'Product record deleted successfully.');
        return redirect()->back()->with($success);
    }

   public function addToCart($id){
       $product = Product::find($id);
       if(!$product){
        $error = Session::flash('error', 'Invalid product given.');
        return redirect()->to('/')->with($error);
       }
      $cart = session()->get('cart');
      // if cart is empty then this first product
      if(!$cart){
          $cart = [
              $id=>[
                  "name"=>$product->name,
                  "quantity"=>1,
                  "price"=>$product->price
              ]
          ];
          session()->put('cart', $cart);
          return redirect()->back()->with('success', 'Product added to cart successfully');
      }
      // if cart is n
   }

}
