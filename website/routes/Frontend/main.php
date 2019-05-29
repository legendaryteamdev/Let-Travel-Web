<?php

Route::get('/home', 								[ 'as' => 'home',						'uses' => 'HomeController@index']);

Route::get('/about-us', 			[ 'as' => 'about-us',			'uses' => 'AboutUsController@index']);
Route::get('/contact-us', 		[ 'as' => 'contact-us',		'uses' => 'ContactUsController@index']);
Route::get('/resort', 		[ 'as' => 'resort',		'uses' => 'ResortController@index']);
Route::get('/province', 			[ 'as' => 'province',		'uses' => 'ProvinceController@index']);
Route::get('/resort/resort-detail', 			[ 'as' => 'resort-detail',		'uses' => 'ResortDetailController@index']);