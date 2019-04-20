<?php

$controller = 'Pothole\Controller@';
$api->get('/', 											['uses' => $controller.'list']);
$api->get('/{id}', 										['uses' => $controller.'view']);
$api->post('/{id}', 									['uses' => $controller.'update']);
$api->put('/', 											['uses' => $controller.'create']); 
//$api->delete('/{id}', 									['uses' => $controller.'delete']); 
$api->delete('/', 										['uses' => $controller.'delete']);

$controller = 'Pothole\StatusController@';
$api->post('/{id}/statuses', 								['uses' => $controller.'create']); //add
$api->post('/{id}/statuses/{statusId}/files', 				['uses' => $controller.'addFiles']); //add

$controller = 'Pothole\ConsultController@';
$api->post('/{id}/consults', 								['uses' => $controller.'create']); //add


