<?php



// $api->post('/login', 			['as' => 'login', 			'uses' => 'Auth\LoginController@login']);    
// $api->post('/get-reset-password-code', 			['as' => 'get-reset-password-code', 			'uses' => 'Auth\ForgotPasswordController@getResetPasswordCode']);   
// $api->post('/verify-reset-password-code', 			['as' => 'verify-reset-password-code', 			'uses' => 'Auth\ForgotPasswordController@verifyResetPasswordCode']);
// $api->post('/change-password', 			['as' => 'change-password', 			'uses' => 'Auth\ForgotPasswordController@changePassword']);   

// $api->post('/login', 							['uses' => 'Auth\LoginController@login']);   
// $api->post('/get-reset-password-code', 			['uses' => 'Auth\ForgotPasswordController@getResetPasswordCode']);   
// $api->post('/verify-reset-password-code', 		['uses' => 'Auth\ForgotPasswordController@verifyResetPasswordCode']);
// $api->post('/change-password', 					['uses' => 'Auth\ForgotPasswordController@changePassword']);   


$api->post('/login', 							['uses' => 'Auth\LoginController@login']);   
$api->post('/get-reset-password-code', 			['uses' => 'Auth\ForgotPasswordController@getResetPasswordCode']);   
$api->post('/verify-reset-password-code', 		['uses' => 'Auth\ForgotPasswordController@verifyResetPasswordCode']);
$api->post('/change-password', 					['uses' => 'Auth\ForgotPasswordController@changePassword']);  
