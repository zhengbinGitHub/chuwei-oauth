<?php
/**
 * Created by PhpStorm.
 * User: maczheng
 * Date: 2020-12-01
 * Time: 11:16
 */

namespace CwApp\Controllers\Api;


use CwApp\Models\ApiApp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
    /**
     * @var ApiApp
     */
    private $apiApp;

    /**
     * TestController constructor.
     */
    public function __construct(ApiApp $apiApp)
    {
        $this->apiApp = $apiApp;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $info = $this->apiApp->where('app_id', $request->appid)->first();
        if(!$info->id){
            return json_encode(['code' => '-1', 'message' => '应用信息为空']);
        }
        return json_encode(['code' => 0, 'message' => 'ok', 'data' => ['app_id' => $info->app_id, 'app_secret' => $info->app_secret]]);
    }
}