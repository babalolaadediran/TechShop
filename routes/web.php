// <?php
//
// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */
//
// # welcome page
// Route::get('/', 'UserController@index');
//
// #signup page
// Route::get('/signup', function () {
//     return view('signup');
// });
//
// #signup user
// Route::post('/signup', 'UserController@registerUser');
//
// # login page
// Route::get('/login', function () {
//     return view('login');
// });
//
// # log user in
// Route::post('/login', 'UserController@loginUser');
//
// # add product page
// Route::get('/products/add', function(){
// 	return view('add_product');
// });
//
// # add new product
// Route::post('/products/add', 'ProductController@store');
//
// # edit product
// Route::get('/products/edit/{productId}', 'ProductController@edit');
//
// # update product
// Route::post('/products/edit/{productId}', 'ProductController@updateProduct');
//
// # delete product
// Route::post('/products/delete/{productId}', 'ProductController@deleteProduct');
//
// # load make order page
// Route::get('/make/order/{productId}', 'OrderController@requestOrderPage');
//
// # create user order
// Route::post('/make/order/{productId}', 'OrderController@store');
//
// # view orders
// Route::get('/orders', 'OrderController@index');
//
// # manage user orders
// Route::get('/manage/orders', 'OrderController@show');
//
// # make order delivered
// Route::post('/manage/orders/update/{id}', 'OrderController@deliverOrder');
//
// # logout
// Route::get('/logout', 'UserController@logout');
//<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# welcome page
Route::get('/', 'UserController@index');

#signup page
Route::get('/signup', function () {
    return view('signup');
});

#signup user
Route::post('/signup', 'UserController@registerUser');

# login page
Route::get('/login', function () {
    return view('login');
});

# log user in
Route::post('/login', 'UserController@loginUser');

# add category page
Route::get('/category', function(){
	return view('add_category');
});

# add product page
Route::get('/products', function(){
    $categories = \App\Category::all();
	return view('add_product')->with(['categories' => $categories]);
});


# add new Category
Route::post('/category/add', 'CategoryController@store');

# edit Category
Route::get('/category/edit/{catid}', 'CategoryController@edit');

# update Category
Route::post('/category/edit/{catid}', 'CategoryController@updateCategory');

# delete Category
Route::post('/category/delete/{catid}', 'CategoryController@deleteCategory');


# add new product
Route::post('/products/add', 'ProductController@store');

# edit product
Route::get('/products/edit/{productId}', 'ProductController@edit');

# update product
Route::post('/products/edit/{productId}', 'ProductController@updateProduct');

# delete product
Route::post('/products/delete/{productId}', 'ProductController@deleteProduct');

# load make order page
Route::get('/make/order/{productId}', 'OrderController@requestOrderPage');

# create user order
Route::post('/make/order/{productId}', 'OrderController@store');

# view orders
Route::get('/orders', 'OrderController@index');

# manage user orders
Route::get('/manage_orders', 'OrderController@show');

# make order delivered
Route::post('/manage/orders/update/{id}', 'OrderController@deliverOrder');

# logout
Route::get('/logout', 'UserController@logout');
