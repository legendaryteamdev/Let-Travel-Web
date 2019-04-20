<?php

$api->post('/login', 							['uses' => 'Auth\LoginController@login']);   
$api->post('/get-reset-password-code', 			['uses' => 'Auth\ForgotPasswordController@getResetPasswordCode']);   
$api->post('/verify-reset-password-code', 		['uses' => 'Auth\ForgotPasswordController@verifyResetPasswordCode']);
$api->post('/change-password', 					['uses' => 'Auth\ForgotPasswordController@changePassword']);  
