<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

// Route::get('/', function () {
//     return view('welcome');
//     // $user = Auth::user();
//     // if($user->isAdmin()){    
//     // echo $user->name . " is an Administrator";
//     // } else echo "User is a subscriber";

// });

 Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/last', function(){
//     return User::orderBy('id','desc')->first();
// });

// Route::get('/admins', 'App\Http\Controllers\AdminController@index');

// Route::get('/email', function(){
//     $data = [
//         'title'=>'This is a new laravel mail',
//         'content'=>'This is the content of the laravel mail'
//     ];

//     Mail::send('emails.newmail', $data , function($message){
//         $message->to('maejima6100@gmail.com','Stathorin')->subject('NewMail 1');
//     });

// });

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/post/{id}', 'App\Http\Controllers\PostController@show')->name('post');
Route::get('/posts/user/{user}', 'App\Http\Controllers\PostController@showUserPosts')->name('userposts');

Route::middleware('auth')->group(function(){
    Route::post('/post/{post}','App\Http\Controllers\CommentController@store')->name('comment.store');
    Route::post('/post/store/{comment}','App\Http\Controllers\NestedcommentController@store')->name('nestedcomment.store');
    Route::get('/post/{post}/like', 'App\Http\Controllers\LikeController@create')->name('like.create');
});

Route::middleware(['auth','role:Moderator,AdmiN,uSER'])->group(function(){
    Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin.index');

    Route::get('/admin/posts/create', 'App\Http\Controllers\PostController@create')->name('posts.create');
    Route::post('/admin/posts', 'App\Http\Controllers\PostController@store')->name('posts.store');
    Route::get('/admin/posts', 'App\Http\Controllers\PostController@index')->name('posts.index');
    Route::delete('/admin/posts/{post}/destroy', 'App\Http\Controllers\PostController@destroy')->name('posts.destroy');
    Route::get('/admin/posts/{post}/edit', 'App\Http\Controllers\PostController@edit')->name('posts.edit');
    Route::patch('/admin/posts/{post}/update', 'App\Http\Controllers\PostController@update')->name('posts.update');
    Route::get('/admin/posts/{post}/views', 'App\Http\Controllers\PostController@deleteviews')->name('post.viewsdelete');

    Route::get('/admin/users/profile', 'App\Http\Controllers\UserController@show')->name('user.profile.show');
    Route::patch('/admin/users/update', 'App\Http\Controllers\UserController@update')->name('user.profile.update');

});

Route::middleware(['auth','role:Moderator,AdmiN'])->group(function(){
    Route::get('/admin/users', 'App\Http\Controllers\UserController@index')->name('users.index');
    Route::get('/admin/users/{id}/profile/edit', 'App\Http\Controllers\UserController@edit')->name('users.profile.edit');
    Route::patch('/admin/users/{user}/profile/update', 'App\Http\Controllers\UserController@updateUsers')->name('users.profile.update');
    Route::delete('/admin/users/{user}/destroy', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');

    Route::get('/admin/comments', 'App\Http\Controllers\CommentController@index')->name('comments.index');
    Route::get('/admin/nested-comments', 'App\Http\Controllers\NestedcommentController@index')->name('nestedcomments.index');
    Route::delete('/admin/comments/{comment}/destroy', 'App\Http\Controllers\CommentController@destroy')->name('comments.destroy');
    Route::delete('/admin/nested-comments/{nestedcomment}/destroy', 'App\Http\Controllers\NestedcommentController@destroy')->name('nestedcomments.destroy');
    Route::get('/admin/comments/{comment}/edit', 'App\Http\Controllers\CommentController@edit')->name('comments.edit');
    Route::get('/admin/nested-comments/{nestedcomment}/edit', 'App\Http\Controllers\NestedcommentController@edit')->name('nestedcomments.edit');
    Route::patch('/admin/comments/{comment}/update','App\Http\Controllers\CommentController@update')->name('comments.update');
    Route::patch('/admin/nested-comments/{nestedcomment}/update','App\Http\Controllers\NestedcommentController@update')->name('nestedcomments.update');


});

Route::middleware('role:Admin')->group(function(){
    Route::get('/admin/roles', 'App\Http\Controllers\RoleController@index')->name('roles.index');
    Route::delete('/admin/roles/{role}/destroy', 'App\Http\Controllers\RoleController@destroy')->name('roles.destroy');
    Route::post('/admin/roles', 'App\Http\Controllers\RoleController@store')->name('roles.store');
    Route::get('/admin/roles/{role}/edit', 'App\Http\Controllers\RoleController@edit')->name('roles.edit');
    Route::patch('/admin/roles/{role}/update', 'App\Http\Controllers\RoleController@update')->name('roles.update');

    Route::get('/admin/permissions', 'App\Http\Controllers\PermissionController@index')->name('permissions.index');
    Route::delete('/admin/permissions/{permission}/destroy', 'App\Http\Controllers\PermissionController@destroy')->name('permissions.destroy');
    Route::post('/admin/permissions', 'App\Http\Controllers\PermissionController@store')->name('permissions.store');
    Route::get('/admin/permissions/{permission}/edit', 'App\Http\Controllers\PermissionController@edit')->name('permissions.edit');
    Route::patch('/admin/permissions/{permission}/update', 'App\Http\Controllers\PermissionController@update')->name('permissions.update');

});