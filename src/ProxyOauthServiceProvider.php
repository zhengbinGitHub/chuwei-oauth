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
        $this->app->make('ChuWei\Client\Oauth\Controllers\Api\AuthTokenController');
        $this->app->make('ChuWei\Client\Oauth\Controllers\Api\TestController');
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/cwapp.php', 'cwapp');
        }

        //注册应用
        $this->app->singleton('chuwei-oauth', function($app){
            return new ProxyOauthManager($app['config']);
        });
    }

    /**
     * 覆盖发布文件 php artisan vendor:publish --force
     */
    public function boot()
    {
        $this->addMiddlewareAlias('cwapp-api.auth', CwAppApiMiddleware::class);

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['chuwei-oauth'];
    }
}