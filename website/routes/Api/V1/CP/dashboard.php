<?php

$controller = 'Dashboard\Controller@';

$api->get('/', 		['uses' => $controller.'getData']);


