<?php

use Illuminate\Support\Facades\DB;

$api->get('/{table}', 			[function($table){
	$data = DB::table($table)->select('*')->whereNull('deleted_at')->get();
	return response()->json($data, 200);
}]);
