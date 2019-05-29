<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\Auth'], function($api) {
		
		$api->post('/login', 			            	['uses' => 'LoginController@login']); 
		$api->post('/register', 			        	['uses' => 'RegisterController@register']); 

		$api->post('/request-security-code', 			['uses' => 'AccountController@getSecurityCode']);   
		$api->post('/verify-security-code', 			['uses' => 'AccountController@verifyCode']);
		$api->post('/reset-password', 			    	['uses' => 'AccountController@resetPassword']);  

		$api->delete('/delete', 			    		['uses' => 'AccountController@delete']); 

		$api->group(['middleware' => 'api.auth', 'prefix' => 'profile'], function($api) {
			$api->get('/', 			    				['uses' => 'AccountController@view']);
			$api->post('/change-password', 			    ['uses' => 'AccountController@changePassword']);  
			$api->post('/update', 			    		['uses' => 'AccountController@updateProfile']);  
			$api->post('/refresh-token', 			    ['uses' => 'AccountController@refreshToken']);  
			
			
		});

		
	});