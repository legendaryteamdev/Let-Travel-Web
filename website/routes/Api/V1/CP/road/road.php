<?php

//========================>> Detail
$api->get('/{roadId}/pks', 						['uses' => 'Road\PKController@list']);
$api->get('/{roadId}/parts', 					['uses' => 'Road\PartController@list']);

//========================>> Authority
//Ministry
$api->get('/{roadId}/ministries', 				['uses' => 'Road\MinistryController@list']);
$api->post('/{roadId}/ministries', 				['uses' => 'Road\MinistryController@post']); //Add
$api->delete('/{roadId}/ministries/{id}', 		['uses' => 'Road\MinistryController@delete']); //Remove

//MO
$api->get('/{roadId}/mos', 						['uses' => 'Road\MOController@list']);
$api->post('/{roadId}/mos', 					['uses' => 'Road\MOController@post']); //Add
$api->delete('/{roadId}/mos/{id}', 				['uses' => 'Road\MOController@delete']); //Remove
$api->get('/mos', 								['uses' => 'Road\MOController@byMinistry']);

//MT
$api->get('/{roadId}/mts', 						['uses' => 'Road\MTController@list']);
$api->post('/{roadId}/mts', 					['uses' => 'Road\MTController@post']); //Add
$api->delete('/{roadId}/mts/{id}', 				['uses' => 'Road\MTController@delete']); //Remove
$api->get('/mts', 								['uses' => 'Road\MTController@myMO']);

//=========================>> Road
$controller = 'Road\Controller@';
$api->get('', 												['uses' => $controller.'list']);
$api->get('/{id}', 											['uses' => $controller.'view']);
$api->put('/{id}', 											['uses' => $controller.'put']); //Update
//$api->post('/', 											['uses' => $controller.'post']); //Add new
//$api->delete('/{id}', 										['uses' => $controller.'delete']);

