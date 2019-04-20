<?php

$controller = 'MO\Controller@';
$api->get('/', 							['uses' => $controller.'list']);
$api->get('/{id}', 						['uses' => $controller.'view']);
$api->get('/{id}/roads', 				['uses' => $controller.'roads']);


