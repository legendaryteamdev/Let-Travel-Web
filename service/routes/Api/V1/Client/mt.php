<?php

$controller = 'MT\Controller@';
$api->get('/mos', 												['uses' => $controller.'mos']);
$api->get('/maintence-codes', 									['uses' => $controller.'maintenceCodes']);

$api->group(['prefix' => 'potholes'], function ($api) {
	$controller = 'MT\PotholeController@';
	$api->get('/', 											['uses' => $controller.'list']);
	$api->get('/{id}', 										['uses' => $controller.'view']);

	$controller = 'MT\StatusController@';
	$api->post('/{id}/statuses', 							['uses' => $controller.'create']); //add
	$api->post('/{id}/statuses/{statusId}/files', 			['uses' => $controller.'addFiles']); //add

	$controller = 'MT\ConsultController@';
	$api->post('/{id}/consults', 							['uses' => $controller.'create']); //add
}); 

