<?php
//================================================================>>> Road
// $api->group(['prefix' 			=> 'roads'], function ($api) {
//     $controller 				= 'Ministry\RoadController@';
// 	$api->get('{id}/', 			['uses' => $controller.'search']);
// 	$api->get('/{id}/roads', 	['uses' => $controller.'list']);
// });

//================================================================>>> Ministry
$controller 				= 'Ministry\Controller@';
$api->get('/', 				['uses' => $controller.'list']);//all 
$api->get('/{id}', 			['uses' => $controller.'view']);//view single
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
$api->post('/', 			['uses' => $controller.'post']); //Add new
$api->delete('/{id}', 		['uses' => $controller.'delete']);//delete

//================================================================>>> Road
$controller 				= 'Ministry\RoadController@';
$api->get('{id}/roads', 			['uses' => $controller.'search']);

/**
 * Get Mos
 */
$Controller = 'Ministry\MoController';
$api->get('/~/mos', 									['uses' => $Controller.'@gets']);
$api->get('/{id}/existing-mos', 						['uses' => $Controller.'@getExisting']);
$api->put('/{id}/add-mos', 								['uses' => $Controller.'@put']);
$api->delete('/{id}/remove-mos/{ministry_mo_id}', 		['uses' => $Controller.'@delete']);

/**
 * Get MT
 */
$Controller = 'Ministry\MtController';
$api->get('/{id}/mts', 						['uses' => $Controller.'@list']);



