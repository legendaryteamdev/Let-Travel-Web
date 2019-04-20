<?php

$controller = 'Report\Controller@';
$api->get('/draft', 									['uses' => $controller.'draft']);

$api->get('/', 											['uses' => $controller.'list']);
$api->get('/{id}', 										['uses' => $controller.'view']);
$api->post('/', 										['uses' => $controller.'create']);
$api->put('/{id}', 										['uses' => $controller.'update']); 
//$api->delete('/{id}', 									['uses' => $controller.'delete']); 
$api->delete('/', 										['uses' => $controller.'delete']);

$controller = 'Report\FileController@';
$api->post('/{id}/files', 								['uses' => $controller.'addFiles']);
$api->delete('/{id}/files/{fileId}', 					['uses' => $controller.'removeFile']);

$controller = 'Report\CommentController@';
$api->post('/{id}/comments', 							['uses' => $controller.'addComemnt']);
$api->post('/{id}/comments/{commentId}', 				['uses' => $controller.'updateComemnt']);
$api->delete('/{id}/comments/{commentId}', 				['uses' => $controller.'removeComemnt']);

