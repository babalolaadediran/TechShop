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
use App\Category;

class CategoryController extends Controller
{
    /**
    * store Category
    */
    public function store(Request $request)
    {
    	try{
    		$rules = [
    			'name'=>'required',
    			'description'=> 'required'
    		];

    		$validator = Validator::make($request->all(), $rules);

    		if($validator->fails()){
                dd($validator);
    			return redirect()->back()->withInput()->withErrors($validator);
    		}

    		// collect data

    		$name = strtolower($request->name);
    		$description = $request->description;

    		// validate if product already exist.
    		$validateCategory = Category::where('name', $name)->first();

    		if($validateCategory){
    			$error = Session::flash('error', 'Category already exist.');
	    		return redirect()->back()->withInput()->with($error);
    		}

    		// create product record
    		Category::create([
    			'name'=>$name,
    			'description'=>$description
    		]);

    		// return success message
    		$success = Session::flash('success', 'Category Added successfully.');
    		return redirect()->back()->with($success);
    	}catch(\Exception $ex){
    		$error = Session::flash('error', $ex->getMessage());
    		return redirect()->back()->with($error);
    	}
    }

    /*
    * Edit Category
    */
    public function edit(Request $request, $catid)
    {
        try{

            // check if category exist
            $getCategoryDeatils = Category::where('id', $catid)->first();

            if(!$getCategoryDeatils){
                $error = Session::flash('error', 'Record not found.');
                return redirect()->back()->with($error);
            }

            // return record
            return view::make('edit_category')->with(['getCategoryDeatils'=> $getCategoryDeatils]);
        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * update product
    */
    public function updateCategory(Request $request, $catid)
    {
        try{

           $rules = [
                'name'=>'required',
                'description'=> 'required'
           ];

           $validator = Validator::make($request->all(), $rules);

           if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
           }

            // get product details
            $categoryDetails = Category::find($catid);

            // collect data
            $name = strtolower($request->name);
            $description = $request->description;

            $update = Category::find($catid)->update([
                'name'=>$name,
                'description'=>$description
            ]);

            $success = Session::flash('success', 'Category details updated successfully.');
            return redirect()->to('/')->with($success);

        }catch(\Exception $ex){
            $error = Session::flash('error', $ex->getMessage());
            return redirect()->back()->with($error);
        }
    }

    /**
    * delete Category
    */
    public function deleteCategory(Request $request, $catid)
    {
        // check for Category
        $validateCategory = Category::find($catid);

        if(!$validateCategory){
            $error = Session::flash('error', 'Failed to delete Category record.');
            return redirect()->to('/')->with($error);
        }

        // delete Category
        $validateCategory->delete();

        $success = Session::flash('success', 'Category record deleted successfully.');
        return redirect()->back()->with($success);
    }

}
