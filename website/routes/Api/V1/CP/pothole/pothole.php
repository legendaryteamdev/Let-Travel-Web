<?php

$controller = 'Pothole\Controller@';
$api->get('/', 												['uses' => $controller.'list']);
$api->get('/{id}', 											['uses' => $controller.'view']);
$api->put('/{id}', 											['uses' => $controller.'put']); //Update
$api->delete('/{id}', 										['uses' => $controller.'delete']);
$api->get('/{id}/files', 									['uses' => $controller.'files']);

$controller = 'Pothole\ConsultController@';
$api->get('/{id}/consults/list', 					['uses' => $controller.'list']);

$controller = 'Pothole\ReporterController@';
$api->get('/{id}/reporters/list', 					['uses' => $controller.'list']);
$api->get('/{id}/reporters/view/{report_id}', 		['uses' => $controller.'view']);
