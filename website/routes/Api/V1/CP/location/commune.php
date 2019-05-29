<?php

$controller = 'Commune\Controller@';
$api->get('/', 				['uses' => $controller.'list']);
$api->get('/{id}', 			['uses' => $controller.'view']);
$api->put('/{id}', 			['uses' => $controller.'put']); //Update

$controller = 'Commune\VillageController@';
$api->get('/{id}/villages', 				['uses' => $controller.'list']);






