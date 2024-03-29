<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    if (Redis::ping() == 'PONG') {
        echo 'Redis is connected! <br/>';
    } else {
        echo 'Redis is not connected! <br/>';
    }

    Redis::publish('notify', json_encode([
        'message' => 'Welcome User Service'
    ]));

    return view('welcome');
});
