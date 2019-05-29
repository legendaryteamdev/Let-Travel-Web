<?php

		Route::get('not-allow', 		['as' => 'not-allow', 					'uses' => 'AccessController@showUnaccessForm']);// Not allow to access
		Route::get('login', 			['as' => 'login', 						'uses' => 'LoginController@showLoginForm']);// Check if seeker has login, if not, display login form
		Route::post('login', 			['as' => 'authenticate', 				'uses' => 'LoginController@login']);//Check database using username and password

		//Route::post('verify-code', 			['as' => 'verify-code', 				'uses' => 'LoginController@login']);//Check database using 

		Route::get('forgot-password', 	['as' => 'forgot-password', 			'uses' => 'ForgotPasswordController@showLinkRequestForm']);//display forgot password form
		Route::post('forgot-password', 	['as' => 'make-forgot-password-code', 	'uses' => 'ForgotPasswordController@sendResetLinkEmail']); //Get an Email from user and compare to database
		Route::get('reset-password', 	['as' => 'reset-password', 				'uses' => 'ResetPasswordController@showResetForm']); //After verify the code, a form of reseting new password is here
		Route::post('reset-password', 	['as' => 'submit-reset-password', 		'uses' => 'ResetPasswordController@reset']); // Get new password from the form and change
		Route::get('logout', 			['as' => 'logout', 						'uses' => 'LoginController@logout']);//Logout from system

		Route::get('verify-device', 			['as' => 'verify-device', 						'uses' => 'VerifyDeviceController@showVerifyForm']);// Check if seeker has login, if not, display login form

		Route::post('submit-code', 			['as' => 'submit-code', 				'uses' => 'VerifyDeviceController@submitCode']);