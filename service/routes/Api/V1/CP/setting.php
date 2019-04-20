<?php
$api->group(['prefix'=>'maintence-codes'], function($api) {
    $controller = 'MaintenceCodeController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});

$api->group(['prefix'=>'maintence-groups'], function($api) {
    $controller = 'MaintenceGroupController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});

$api->group(['prefix'=>'maintence-types'], function($api) {
    $controller = 'MaintencTypeController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});

$api->group(['prefix'=>'maintence-sub-types'], function($api) {
    $controller = 'MaintencSubTypeController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});

$api->group(['prefix'=>'maintence-units'], function($api) {
    $controller = 'MaintencUnitController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});



$api->group(['prefix'=>'status'], function($api) {
    $controller = 'StatusController@';
    $api->get('/',              ['uses' => $controller.'list']);
    $api->get('/{id}',          ['uses' => $controller.'view']);
    $api->put('/{id}',          ['uses' => $controller.'put']); //Update
    $api->post('/',             ['uses' => $controller.'post']); //Add new
    $api->delete('/{id}',       ['uses' => $controller.'delete']);
});

