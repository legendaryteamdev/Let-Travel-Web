<?php

$controller = 'Reporter\Controller@';
$api->get('/list', 			['uses' => $controller.'list']);
$api->get('/view/{id}', 	['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
$api->post('/', 			['uses' => $controller.'post']); //Add new
$api->delete('/{id}', 		['uses' => $controller.'delete']);

$controller = 'Reporter\ScoreController@';
$api->get('/{id}/scores/list', 					['uses' => $controller.'list']);

$controller = 'Reporter\ReportController@';
$api->get('/{id}/reports/list', 					['uses' => $controller.'list']);