<?php

	//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Auth
	Route::group(['as' => 'auth.', 'prefix' => 'auth', 'namespace' => 'Auth'], function(){	
		require(__DIR__.'/auth.php');
	});
	
	//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Authensicated
	Route::group(['middleware' => 'authenticatedUser'], function() {
		//:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Dashboard

		Route::group(['as' => 'dashboard.',  'prefix' => 'dashboard', 'namespace' => 'Dashboard'], function () {
			require(__DIR__.'/dashboard.php');
		});
		

		Route::group(['as' => 'user.',  'prefix' => 'user', 'namespace' => 'User'], function () {
			require(__DIR__.'/user.php');
		});
		// Route::group(['as' => 'automation.',  'prefix' => 'automation', 'namespace' => 'Automation'], function () {
		// 	require(__DIR__.'/automation.php');
		// });
		// Route::group(['as' => 'document.',  'prefix' => 'document', 'namespace' => 'Document'], function () {
		// 	require(__DIR__.'/document.php');
		// });
		// Route::group(['as' => 'project.',  'prefix' => 'project', 'namespace' => 'Project'], function () {
		// 	require(__DIR__.'/project.php');
		// });
		// Route::group(['as' => 'press.',  'prefix' => 'press', 'namespace' => 'Press'], function () {
		// 	require(__DIR__.'/press.php');
		// });
		// Route::group(['as' => 'organization.',  'prefix' => 'organization', 'namespace' => 'Organization'], function () {
		// 	require(__DIR__.'/organization.php');
		// });

		// Route::group(['as' => 'public_work.',  'prefix' => 'public-work', 'namespace' => 'PublicWork'], function () {
		// 	require(__DIR__.'/public_work.php');
		// });
		// Route::group(['as' => 'website.',  'prefix' => 'website', 'namespace' => 'Website'], function () {
		// 	require(__DIR__.'/website.php');
		// });
		// Route::group(['as' => 'app.',  'prefix' => 'app', 'namespace' => 'App'], function () {
		// 	require(__DIR__.'/app.php');
		// });
		// Route::group(['as' => 'banner.',  'prefix' => 'banner', 'namespace' => 'Banner'], function () {
		// 	require(__DIR__.'/banner.php');
		// });
		// Route::group(['as' => 'contact.',  'prefix' => 'contact', 'namespace' => 'Contact'], function () {
		// 	require(__DIR__.'/contact.php');
		// });
		// Route::group(['as' => 'message.',  'prefix' => 'message', 'namespace' => 'Message'], function () {
		// 	require(__DIR__.'/message.php');
		// });
		// Route::group(['as' => 'image.',  'prefix' => 'image', 'namespace' => 'Image'], function () {
		// 	require(__DIR__.'/image.php');
		// });
		// Route::group(['as' => 'category.',  'prefix' => 'category', 'namespace' => 'Category'], function () {
		// 	require(__DIR__.'/category.php');
		// });
		// Route::group(['as' => 'document-category.',  'prefix' => 'document-category', 'namespace' => 'DocumentCategory'], function () {
		// 	require(__DIR__.'/document-category.php');
		// });
		// //:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Setup
		// Route::group(['as' => 'setup.', 'prefix' => 'setup', 'namespace' => 'Setup'], function () {
		// 	require(__DIR__.'/setup.php');
		// });
		// //:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Setup
		// Route::group(['as' => 'biography.', 'prefix' => 'biography', 'namespace' => 'Biography'], function () {
		// 	require(__DIR__.'/biography.php');
		// });
		// //:::::::::::::>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Setup
		// Route::group(['as' => 'popup.', 'prefix' => 'popup', 'namespace' => 'Popup'], function () {
		// 	require(__DIR__.'/popup.php');
		// });
		// Route::group(['as' => 'greeting.', 'prefix' => 'greeting', 'namespace' => 'Greeting'], function () {
		// 	require(__DIR__.'/greeting.php');
		// });
	});