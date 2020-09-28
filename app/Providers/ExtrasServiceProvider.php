<?php
namespace App\Providers;

use App\Channels\WhatsAppChannel;
use App\Console\Commands\WorkCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class ExtrasServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'zip',
            function ($app) {
                return new \App\Services\Zip($app);
            }
        );

        $channels = [
            'whatsapp' => WhatsAppChannel::class,
        ];
        foreach ($channels as $name => $className) {
            Notification::extend($name, function () use ($className) {
                return new $className;
            });
        }

        $this->registerWorkCommand();
    }

    /**
     * Get the services provider by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['zip'];
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerWorkCommand()
    {
        $this->app->extend('command.queue.work', function ($command, $app) {
            return new WorkCommand($app['queue.worker']);
        });
    }
}
