<?php

	
	$api->group(['namespace' => 'App\Api\V1\Controllers\CP'], function($api) {
		//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Making Auth
		$api->group([ 'prefix' => 'auth'], function ($api) {
			require(__DIR__.'/auth.php');
		});
		
		//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Authensicated
		//$api->group(['middleware' => 'api.auth'], function($api) {
		$api->group([], function($api) {

			$api->group(['prefix' => 'quick-get'], function ($api) {
				require(__DIR__.'/quick-get.php');
			});
			
			$api->group(['prefix' => 'dashboard'], function ($api) {
				require(__DIR__.'/dashboard.php');
			});

			//Authority
			$api->group(['prefix' => 'authorities', 'namespace'=>'Authority'], function ($api) {
				$api->group(['prefix' => 'ministries'], function ($api) {
					require(__DIR__.'/authority/ministry.php');
				});

				$api->group(['prefix' => 'mos'], function ($api) {
					require(__DIR__.'/authority/mo.php');
				});

				$api->group(['prefix' => 'mts'], function ($api) {
					require(__DIR__.'/authority/mt.php');
				});
			});

			$api->group(['prefix' => 'locations', 'namespace'=>'Location'], function ($api) {
				//=========== Provinces
				$api->group(['prefix' => 'provinces'], function ($api) {
					require(__DIR__.'/location/province.php');
				});
				//=========== District
				$api->group(['prefix' => 'districts'], function ($api) {
					require(__DIR__.'/location/district.php');
				});
				//=========== Commune
				$api->group(['prefix' => 'communes'], function ($api) {
					require(__DIR__.'/location/commune.php');
				});
				//=========== Village
				$api->group(['prefix' => 'villages'], function ($api) {
					require(__DIR__.'/location/village.php');
				});
			});

			$api->group(['prefix' => 'potholes'], function ($api) {
				require(__DIR__.'/pothole/pothole.php');
			});

			$api->group(['prefix' => 'roads'], function ($api) {
				require(__DIR__.'/road/road.php');
			});

			$api->group(['prefix' => 'reporters'], function ($api) {
				require(__DIR__.'/reporter.php');
			});

			$api->group(['prefix' => 'setting','namespace'=>'Setting'], function ($api) {
				require(__DIR__.'/setting.php');
			});
			$api->group(['prefix' => 'user'], function ($api) {
				require(__DIR__.'/user.php');
			});
			$api->group(['prefix' => 'my-profile'], function ($api) {
				require(__DIR__.'/my-profile.php');
			});
			
		});
		
	});