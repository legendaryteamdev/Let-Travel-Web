<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

	$api->group(['prefix' => 'auth', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/Auth/main.php');
    });
	
    $api->group(['prefix' => 'cp', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/CP/main.php');
    });

    $api->group(['prefix' => 'mo', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/MO/main.php');
    });

    $api->group(['prefix' => 'mt', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/MT/main.php');
    });

    $api->group(['middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/Client/main.php');
    });

   
    Route::get('/', function () {
        return response()->json(['message'=>'Welcome to Road Care API'], 200);
    });

    // $api->get('/migarate',            ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@migarate']);

    //$api->get('/migarate-location',           ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@location']);
    //$api->get('/migrate-bondary',             ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@addBoundaries']);
    //$api->get('/get-commune-by-ll',             ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@getCommunebyLL']);
    //$api->get('/check-by-point',              ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@checkByPoint']);


    // $api->get('/create-road-data',            ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@createRoadData']); 
    // $api->get('/migarate-roads',              ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@road']);
    // $api->get('/migarate-parts',              ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@part']);


    // $api->get('/migrate-pk-point-by-point-data',     ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@migratePKPointByPoint']);//Point Data
    // $api->get('/migrate-pk-point-by-csv-data', ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@migratePKPointbyCsv']); //Excel Data
    // $api->get('/migrate-pk-point-by-line-data',     ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@migratePKPointByLine']); //Part Data

    // //======================>> Migarate Road Location
    // $api->get('/migrate-road-location',                   ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@migrateRoadLocation']);

    // $api->get('/assign-road-to-authority',                   ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@assignRoadToAuthority']);
    // $api->get('/assign-road-to-mts',                   ['uses' => 'App\Api\V1\Controllers\CP\Migrate\Controller@assignRoadToMT']);

});