<?php

$controller = 'Nearby\NearbyController@';
$api->get('/locations', 								['uses' => $controller.'locations']);
$api->get('/nrs', 										['uses' => $controller.'nrs']);
$api->get('/potholes', 									['uses' => $controller.'potholes']);

