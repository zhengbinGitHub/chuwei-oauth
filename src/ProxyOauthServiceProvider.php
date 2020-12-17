<?php
namespace ChuWei\Client\Oauth;
use ChuWei\Client\Oauth\Middleware\CwAppApiMiddleware;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: maczheng
 * Date: 2020-11-04
 * Time: 17:34
 */

class ProxyOauthServiceProvider extends ServiceProvider
{
    /**
     * 注册信息
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/cwapp.php', 'cwapp');
        }
    }

    /**
     * 覆盖发布文件 php artisan vendor:publish --force
     */
    public function boot()
    {
        $this->addMiddlewareAlias('cwapp-api.auth', CwAppApiMiddleware::class);
    }

    # 添加中间件的别名方法
    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];

        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }

        return $router->middleware($name, $class);
    }
}