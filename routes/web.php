<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// Route::get('/home', function () {
//     return view('home');
// });

Route::get('/home', 'UserController@index')
    ->middleware(['auth'])->name('home');
Route::get('/loginpage', 'UserController@login');

// Route::get('/home/{post}', function($slug){
//         if (!view()->exists($slug))
//         {
//             abort(404);
//         }
//         return view($slug);


// });


Route::get('/product/{name}', 'ProductController@search');

Route::get('/home/{post}', 'UserController@post')->where('post', '[A-z-\_]+');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/test', function () {
    $APPKEY = '0c6153c336706c6105ecb96ba3ab754c';
    $SECRETKEY = 'e778aeca3d660a413fc834deede33c20';

    return 'Bearer ' . base64_encode($APPKEY . ':' . md5($SECRETKEY . time()));;
});


// require __DIR__.'/auth.php';



//
//Route::group(['prefix' => 'admin'], function () {
//    Voyager::routes();
//});



