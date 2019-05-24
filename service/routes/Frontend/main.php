<?php

Route::get('/home', 								[ 'as' => 'home',						'uses' => 'HomeController@index']);

Route::get('/about-us', 			[ 'as' => 'about-us',			'uses' => 'AboutUsController@index']);
Route::get('/contact-us', 		[ 'as' => 'contact-us',		'uses' => 'ContactUsController@index']);
// Route::get('/about-us/message-from-minister', 		[ 'as' => 'message-from-minister',		'uses' => 'AboutUsController@messageFromMinister']);
// Route::get('/about-us/organization-chart', 			[ 'as' => 'organization-chart',		'uses' => 'AboutUsController@orgainizationChart']);