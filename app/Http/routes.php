<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'MainController@index');

Route::post('uploads', 'UploadController@store');

Route::group(['prefix' => 'admin'], function() {

    Route::get('/', 'AdminController@index');

});

//Route::get('phpinfo', 'MainController@phpinfo');

// Route::get('role', function() {

//     $user = App\User::first();

//     if($user->hasRole('Owner')) return 'You are the owner';

//     return 'you are not the owner';

// });


