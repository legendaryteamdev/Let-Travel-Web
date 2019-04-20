<?php

$controller = 'Province\Controller@';
$api->get('/', 				['uses' => $controller.'list']);
$api->get('/{id}', 			['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
// $api->post('/', 			['uses' => $controller.'post']); //Add new
// $api->delete('/{id}', 		['uses' => $controller.'delete']);

$controller = 'Province\DistrictController@';
$api->get('/{id}/districts', 				['uses' => $controller.'list']);

$controller = 'Province\CommuneController@';
$api->get('/{id}/communes', 				['uses' => $controller.'list']);

$controller = 'Province\VillageController@';
$api->get('/{id}/villages', 				['uses' => $controller.'list']);
