<?php

$controller = 'User\Controller@';
$api->get('/list', 							['as' => 'list', 			'uses' => $controller.'list']);
$api->get('/view/{id}', 					['as' => 'view', 			'uses' => $controller.'view']);
$api->put('/{id}', 							['as' => 'put', 			'uses' => $controller.'put']); //Update
$api->post('/', 							['as' => 'post', 			'uses' => $controller.'post']); //Add new
$api->delete('/{id}', 						['as' => 'delete', 			'uses' => $controller.'delete']); 
$api->put('/{id}/update-password', 			['as' => 'put', 			'uses' => $controller.'updatePassword']); //Update


