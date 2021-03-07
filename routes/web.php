<?php

use Illuminate\Support\Facades\Route;

//Namespace Auth
use App\Http\Controllers\Auth\LoginController;

//Namespace Admin
use App\Http\Controllers\Admin\AdminController;

//Namespace User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

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

Route::view('/','welcome')->name('welcome')->middleware('auth');


Route::group(['namespace' => 'Admin','middleware' => 'auth','prefix' => 'admin'],function(){
	
	Route::get('/',[AdminController::class,'index'])->name('admin')->middleware(['can:admin']);


	Route::get('create_contact',[AdminController::class,'create_contact'])->name('create_contact')->middleware(['can:admin']);

	Route::get('datatables_contact',[AdminController::class,'datatables_contact'])->name('datatables_contact')->middleware(['can:admin']);

	Route::post('storecontact',[AdminController::class,'storecontact'])->name('storecontact')->middleware(['can:admin']);

	Route::post('assigncontact',[AdminController::class,'assigncontact'])->name('assigncontact')->middleware(['can:admin']);

	Route::post('updatecontact',[AdminController::class,'updatecontact'])->name('updatecontact')->middleware(['can:admin']);

	Route::post('deletecontact',[AdminController::class,'deletecontact'])->name('deletecontact')->middleware(['can:admin']);

	Route::get('get_list_user',[AdminController::class,'get_list_user'])->name('get_list_user')->middleware(['can:admin']);

	Route::get('history/{id}',[AdminController::class,'get_history'])->name('history')->middleware(['can:admin']);

	//Route Rescource
	Route::resource('/user','UserController')->middleware(['can:admin']);

	//Route View
	
	Route::view('/404-page','admin.404-page')->name('404-page');
	Route::view('/blank-page','admin.blank-page')->name('blank-page');
	Route::view('/buttons','admin.buttons')->name('buttons');
	Route::view('/cards','admin.cards')->name('cards');
	Route::view('/utilities-colors','admin.utilities-color')->name('utilities-colors');
	Route::view('/utilities-borders','admin.utilities-border')->name('utilities-borders');
	Route::view('/utilities-animations','admin.utilities-animation')->name('utilities-animations');
	Route::view('/utilities-other','admin.utilities-other')->name('utilities-other');
	Route::view('/chart','admin.chart')->name('chart');
	Route::view('/tables','admin.tables')->name('tables');
	

});

Route::group(['namespace' => 'User','middleware' => 'auth' ,'prefix' => 'user'],function(){
	Route::get('/',[UserController::class,'index'])->name('user');
	Route::get('/profile',[ProfileController::class,'index'])->name('profile');
	Route::patch('/profile/update/{user}',[ProfileController::class,'update'])->name('profile.update');

	Route::get('datatables_user_contact',[UserController::class,'datatables_user_contact'])->name('datatables_user_contact');
	Route::post('user_updatecontact',[UserController::class,'user_updatecontact'])->name('user_updatecontact');
});

Route::group(['namespace' => 'Auth','middleware' => 'guest'],function(){
	Route::view('/login','auth.login')->name('login');
	Route::post('/login',[LoginController::class,'authenticate'])->name('login.post');
});

// Other
Route::view('/register','auth.register')->name('register');
Route::view('/forgot-password','auth.forgot-password')->name('forgot-password');
Route::post('/logout',function(){
	return redirect()->to('/login')->with(Auth::logout());
})->name('logout');
