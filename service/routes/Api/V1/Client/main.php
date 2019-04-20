<?php

	
	$api->group(['middleware' => 'api.auth', 'namespace' => 'App\Api\V1\Controllers\Client'], function($api) {

		//=========================================================>> Homepage
		// $api->group(['prefix' => 'potholes'], function ($api) {
		// 	require(__DIR__.'/pothole.php');
		// });

		$api->group(['prefix' => 'reports'], function ($api) {
			require(__DIR__.'/report.php');
		});

		$api->group(['prefix' => 'mos'], function ($api) {
			require(__DIR__.'/mo.php');
		});
		
		$api->group(['prefix' => 'mts'], function ($api) {
			require(__DIR__.'/mt.php');
		});

		$api->group(['prefix' => 'nearby'], function ($api) {
			require(__DIR__.'/nearby.php');
		});

		$api->group(['prefix' => 'notifications'], function ($api) {
			require(__DIR__.'/notification.php');
		});

		
	});

