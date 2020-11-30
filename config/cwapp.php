<?php
/**
 * Created by PhpStorm.
 * User: maczheng
 * Date: 2020-11-04
 * Time: 18:03
 */
return [
    'rpc_servers' => env('RPC_SERVERS', 'http://tools.cw100.net/api/hprose-server'),
    'app_prefix' => env('APP_PREFIX', ''),
    'app_guard' => env('APP_GUARD', ''),
    'app_default_client' => env('APP_DEFAULT_CLIENT', ''),
    'app_platform' => env('APP_PLATFORM', '厨卫系统'),
    'clients' => [
        ['name' => '智慧门店开发信息', 'alias' => 'mall', 'sort' => env('APP_DEFAULT_CLIENT')=='mall'?1:0],
        ['name' => '舒适到家开发信息', 'alias' => 'fuwu', 'sort' => env('APP_DEFAULT_CLIENT')=='fuwu'?1:0],
        ['name' => '店酷云进销存开发信息', 'alias' => 'erp', 'sort' => env('APP_DEFAULT_CLIENT')=='erp'?1:0],
    ],
];