<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/02/05
 * Time: 0:20
 */

namespace Chatbox\Heroku;


use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

use Chatbox\Heroku\Commands\Sendmail;
use Chatbox\Heroku\Commands\DBConfig;
use Chatbox\Heroku\Commands\RedisConfig;

class HerokuServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->extend(LoggerInterface::class,function(Logger $log){
            $handler = new StreamHandler('php://stdout', env("APP_LOGLEVEL",Logger::WARNING));
            $handler->setFormatter(new LineFormatter("%message%\n", null, true, true));
            $log->setHandlers([$handler]);
            return $log;
        });

        $this->commands([
            Sendmail::class,
            DBConfig::class,
            RedisConfig::class
        ]);
    }


}