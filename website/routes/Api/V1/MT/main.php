<?php

	
	$api->group(['namespace' => 'App\Api\V1\Controllers\MT'], function($api) {
		//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Making Auth
		$api->group([ 'prefix' => 'auth'], function ($api) {
			require(__DIR__.'/auth.php');
		});
		
		//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Authensicated
		//$api->group(['middleware' => 'api.auth'], function($api) {
		$api->group([], function($api) {

			$api->group(['prefix' => 'dashboard'], function ($api) {
				require(__DIR__.'/dashboard.php');
			});
			$api->group(['prefix' => 'quick-get'], function ($api) {
				require(__DIR__.'/quick-get.php');
			});
			$api->group(['prefix' => 'potholes'], function ($api) {
				require(__DIR__.'/pothole/pothole.php');
			});
			$api->group(['prefix' => 'roads'], function ($api) {
				require(__DIR__.'/road.php');
			});
			$api->group(['prefix' => 'mos'], function ($api) {
				require(__DIR__.'/mo.php');
			});
			$api->group(['prefix' => 'maintence-codes'], function ($api) {
				require(__DIR__.'/maintence-code.php');
			});
			$api->group(['prefix' => 'my-profile'], function ($api) {
				require(__DIR__.'/my-profile.php');
			});
			
			
		});
		
	});