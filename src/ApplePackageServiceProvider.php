<?php
namespace CwApp;
use CwApp\Middleware\CwAppApiMiddleware;
use CwApp\Middleware\CwAppAuthMiddleware;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: maczheng
 * Date: 2020-11-04
 * Time: 17:34
 */

class ApplePackageServiceProvider extends ServiceProvider
{
    /**
     * 注册信息
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make('CwApp\Controllers\AppleController');
        $this->loadViewsFrom(__DIR__.'/views', 'cwapp');
    }

    /**
     * 覆盖发布文件 php artisan vendor:publish --force
     */
    public function boot()
    {
        // 把静态资源发布到laravel public/cwapp 目录下
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'public' => public_path('cwapp'),
        ], 'public');

        //发布配置文件到 laravel config/cwapp.php
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'cwapp.php' => config_path('cwapp.php'),
        ], 'config');

        //数据库表
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'database' => base_path('database/migrations'),
        ], 'database');

        $this->addMiddlewareAlias('cwapp.auth', CwAppAuthMiddleware::class);
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
}