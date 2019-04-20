<?php

$controller = 'MT\Controller@';
$api->get('/', 				['uses' => $controller.'list']);
$api->get('/{id}', 			['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
$api->post('/', 			['uses' => $controller.'post']); //Add new
$api->delete('/{id}', 		['uses' => $controller.'delete']);

// $controller = 'Card\TransactionController@';
// $api->get('/{id}/transacation', 						['uses' => $controller.'get']);
// $api->get('/~/categories', 								['uses' => $controller.'getCategory']);
// $api->get('/{id}/counter-active', 						['uses' => $controller.'getCounter']);


$moController = 'MT\MOController';
$api->get('/~/mos', 									['uses' => $moController.'@gets']);
$api->get('/{id}/existing-mos', 						['uses' => $moController.'@getExisting']);
$api->put('/{id}/add-mos', 								['uses' => $moController.'@put']);
$api->delete('/{id}/remove-mos/{mt_mo_id}', 			['uses' => $moController.'@delete']);

$partController = 'MT\PartController';
$api->get('/~/parts', 									['uses' => $partController.'@gets']);
$api->get('/{id}/existing-parts', 						['uses' => $partController.'@getExisting']);
$api->put('/{id}/add-parts', 							['uses' => $partController.'@put']);
$api->delete('/{id}/remove-parts/{mt_road_part_id}', 	['uses' => $partController.'@delete']);

$controller = 'MT\ActionController@';
$api->get('/{id}/actions/list', 						['uses' => $controller.'list']);
$api->put('/{id}/actions/{action_id}', 					['uses' => $controller.'put']); //Update
$api->post('/{id}/actions', 							['uses' => $controller.'post']); //Add new
$api->delete('/{id}/actions/{action_id}', 				['uses' => $controller.'delete']);
$api->get('/assigners/list', 							['uses' => $controller.'assignersList']);

//================================================================>>> Road
$controller 				        = 'MT\RoadController@';
$api->get('{id}/roads', 			['uses' => $controller.'list']);

//================================================================>>> Ministry
$controller 				        = 'MT\MinistryController@';
$api->get('{id}/ministries', 			['uses' => $controller.'list']);


