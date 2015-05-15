<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', 'MainController@index');

Route::get('phpinfo', 'MainController@phpinfo');