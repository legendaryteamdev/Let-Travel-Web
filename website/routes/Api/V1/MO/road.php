<?php



//=========================>> Road
$controller = 'Road\Controller@';
$api->get('', 												['uses' => $controller.'list']);
$api->get('mts', 											['uses' => $controller.'mts']);

