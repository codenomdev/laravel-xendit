<?php

namespace Codenom\Xendit\Providers;

use Illuminate\Support\ServiceProvider;
use Codenom\Xendit\Xendit;

class XenditServiceProvider extends ServiceProvider
{
    /**
     * Get Config Path
     * 
     * @return string
     */
    public function getConfigPath()
    {
        return __DIR__ . '/../../config/xendit.php';
    }

    /**
     * Boot Service Provider.
     * 
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getConfigPath() => \config_path('xendit.php')
        ], 'config');

        $this->app->singleton('xendit', function ($app) {
            return new Xendit(null, null);
        });

        // Xendit::registerXenditConfig();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigPath(),
            'xendit'
        );
    }
}
