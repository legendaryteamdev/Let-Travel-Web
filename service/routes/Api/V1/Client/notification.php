<?php

$controller = 'Notification\Controller@';
$api->get('/', 								['uses' => $controller.'list']);
$api->post('/update-app-token', 				['uses' => $controller.'updateAppToken']);
$api->post('/test', 						['uses' => $controller.'test']);
$api->post('/{id}', 						['uses' => $controller.'update']);

