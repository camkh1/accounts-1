<?php
/*
|-------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/admin/login', 'BeLoginController@showLogin');
Route::get('/', 'BeLoginController@showLogin');
Route::post('/admin/login', 'BeLoginController@doLogin');
Route::get('/register', 'BeLoginController@creatAccount');
Route::get('/check', 'BeLoginController@checkAccount');
Route::any('/member', 'BeLoginController@checkMember');

Route::get('/send-forget-password', 'BeLoginController@sendResetPassword');
Route::post('/send-forget-password', 'BeLoginController@sendResetPassword');
Route::get('/forget-password', 'BeLoginController@resetPassword');
Route::group(array('before' => 'csrf'), function(){
    Route::post('/register', 'BeLoginController@doLogin');
});


Route::get('/admin/send-forget-password', 'BeLoginController@sendResetPassword');
Route::post('/admin/send-forget-password', 'BeLoginController@sendResetPassword');
Route::get('/admin/forget-password', 'BeLoginController@resetPassword');
Route::get('/account/{id}','BeUserController@myAccountDetail');
Route::get('/user-cron','BeUserController@accountStatus');



Route::get('/admin/dashboard', 'BeLoginController@dashboard'); 
Route::get('/admin/users','BeUserController@listUser');
Route::get('/logout','BeLoginController@doLogout'); 
Route::get('/myaccount','BeUserController@myAccount');

Route::get('/admin/licence','BeLicenceController@listlicence');
Route::any('/admin/licence/add','BeLicenceController@addlicence');

//=============Routes for front end page==============


Route::any('/image/phpthumb/{image}', 'ImageController@phpThumb');
Route::get('/media/image/{width}x{height}/{image}', function($width, $height, $image)
{
    $file = base_path() . '/' . $image;
    // for remote file
    //$file = 'http://i.imgur.com/1YAaAVq.jpg';
    App::make('phpthumb')
        ->create($file)->make('resize', array($width, $height))->show();
    //Thumb::create($file)->make('resize', array($width, $height))->show()->save(base_path() . '/', 'aaa.jpg');
    /*
     Thumb::create($file)->make('resize', array($width, $height))->make('crop', array('center', $width, $height))->show();
     Thumb::create($file)->make('resize', array($width, $height))->make('crop', array('basic', 100, 100, 300, 200))->show();
     Thumb::create($file)->make('resize', array($width, $height))->make('resize', array($width, $height))->show();
     Thumb::create($file)->make('resize', array($width, $height))->make('resize', array($width, $height, 'adaptive'))->save(base_path() . '/', 'aaa.jpg')->show();
     Thumb::create($file)->make('resize', array($width, $height))->rotate(array('degree', 180))->show();
     Thumb::create($file)->make('resize', array($width, $height))->reflection(array(40, 40, 80, true, '#a4a4a4'))->show();
     Thumb::create($file)->make('resize', array($width, $height))->save(base_path() . '/', 'aaa.jpg');
     Thumb::create($file)->make('resize', array($width, $height))->show();
    */

});
