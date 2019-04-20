<?php

$controller = 'Village\Controller@';
$api->get('/', 				['uses' => $controller.'list']);
$api->get('/{id}', 			['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update
// $api->post('/', 			['uses' => $controller.'post']); //Add new
// $api->delete('/{id}', 		['uses' => $controller.'delete']);




