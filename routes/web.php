<?php

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
use App\Http\Controllers\Blog\PostController;

Route::get('/', 'WelcomeCOntroller@index')->name('welcome');
Route::get('blog/posts/{post}', [PostController::class,'show'])->name('blog.show');
Route::get('blog/categories/{category}',[PostController::class,'category'])->name('blog.category');
Route::get('blog/tags/{tag}',[PostController::class,'tag'])->name('blog.tag');
Auth::routes();

Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
    Route::resource('posts', 'PostsController');
    Route::get('trashed-posts', 'PostsController@trashed')->name('trashed-posts.index');
    Route::put('restore-posts/{post}', 'PostsController@restore')->name('restore-posts');
});

Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('users/profile', 'UserController@edit')->name('users.edit-profile');
    Route::put('users/profile', 'UserController@update')->name('users.update-profile');
    Route::get('users', 'UserController@index')->name('users.index');
    Route::put('users/{user}/make-admin', 'UserController@makeAdmin')->name('users.make-admin');
});
