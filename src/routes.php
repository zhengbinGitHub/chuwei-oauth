<?php
/**
 * Created by PhpStorm.
 * User: maczheng
 * Date: 2020-12-15
 * Time: 14:39
 */
//api
Route::group(['namespace' => 'ChuWei\Client\Oauth\Controllers\Api', 'prefix' => 'api'], function ($router){
    $router->get('proxy/auth/token', 'AuthTokenController@index');
    $router->get('test', 'TestController@index')->middleware('cwapp-api.auth');
});