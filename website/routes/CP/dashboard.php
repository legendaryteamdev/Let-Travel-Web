<?php
//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Award

Route::group([], function () {
	Route::get('/', 				['as' => 'index', 			'uses' => 'DashboardController@index']);
	Route::get('/{id}', 			['as' => 'edit', 			'uses' => 'DashboardController@edit']);
	// Route::get('/validate-vpn-invoice', 			['as' => 'validate-vpn-invoice', 			'uses' => 'PaymentController@getTicketLookUp']);
	// Route::post('/submit-vpn-invoice', 				['as' => 'submit-vpn-invoice', 			'uses' => 'PaymentController@commitPayment']);
	// Route::put('/', 				['as' => 'store', 			'uses' => 'DashboardController@store']);
	// Route::delete('/{id}', 			['as' => 'trash', 			'uses' => 'DashboardController@trash']);
	// Route::post('statuse', 			['as' => 'update-statuse', 	'uses' => 'DashboardController@updateStatus']);
	// Route::post('/order', 			['as' => 'order', 			'uses' => 'DashboardController@order']);
	// Route::post('update-featured', 	['as' => 'update-featured', 	'uses' => 'PublicWorkController@updateFeatured']);
	
	
});	