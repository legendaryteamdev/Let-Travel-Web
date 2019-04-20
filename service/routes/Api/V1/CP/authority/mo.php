<?php

$controller = 'MO\Controller@';
$api->get('/', 				['uses' => $controller.'list']);
$api->get('/{id}', 			['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
$api->post('/', 			['uses' => $controller.'post']); //Add new
$api->delete('/{id}', 		['uses' => $controller.'delete']);

$roadController = 'MO\MinistryController';
$api->get('/~/ministries', 									['uses' => $roadController.'@gets']);
$api->get('/{id}/existing-ministries', 						['uses' => $roadController.'@getExisting']);
$api->put('/{id}/add-ministries', 							['uses' => $roadController.'@put']);
$api->delete('/{id}/remove-ministries/{mo_ministry_id}', 	['uses' => $roadController.'@delete']);

$roadController = 'MO\RoadController';
$api->get('/~/roads', 									['uses' => $roadController.'@gets']);
$api->get('/{id}/existing-roads', 						['uses' => $roadController.'@getExisting']);
$api->put('/{id}/add-roads', 							['uses' => $roadController.'@put']);
$api->delete('/{id}/remove-roads/{mo_road_id}', 		['uses' => $roadController.'@delete']);

$mtController = 'MO\MTController';
$api->get('/~/mts', 									['uses' => $mtController.'@gets']);
$api->get('/{id}/existing-mts', 						['uses' => $mtController.'@getExisting']);
$api->put('/{id}/add-mts', 								['uses' => $mtController.'@put']);
$api->delete('/{id}/remove-mts/{mo_mt_id}', 				['uses' => $mtController.'@delete']);

//================================================================>>> Road
$controller 				        = 'MO\RoadController@';
$api->get('{id}/roads', 			['uses' => $controller.'list']);

