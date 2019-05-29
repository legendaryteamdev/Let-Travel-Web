<?php

$controller = 'MO\Controller@';
$api->get('/mts', 												['uses' => $controller.'mts']);
$api->get('/maintence-codes', 									['uses' => $controller.'maintenceCodes']);

$api->group(['prefix' => 'potholes'], function ($api) {
	$controller = 'MO\PotholeController@';
	$api->get('/', 											['uses' => $controller.'list']);
	$api->get('/{id}', 										['uses' => $controller.'view']);
	$api->post('/{id}', 									['uses' => $controller.'update']);
	$api->put('/', 											['uses' => $controller.'create']); 
	//$api->delete('/{id}', 									['uses' => $controller.'delete']); 
	$api->delete('/', 										['uses' => $controller.'delete']);
	$api->get('/{id}/mts', 									['uses' => $controller.'mts']);
	$api->post('/{id}/assign-to-mt', 						['uses' => $controller.'assign']);

	$controller = 'MO\StatusController@';
	$api->post('/{id}/statuses', 							['uses' => $controller.'create']); //add
	$api->post('/{id}/statuses/{statusId}/files', 			['uses' => $controller.'addFiles']); //add

	$controller = 'MO\ConsultController@';
	$api->post('/{id}/consults', 							['uses' => $controller.'create']); //add
}); 

