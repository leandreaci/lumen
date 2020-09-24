<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Aws\CloudWatchLogs\CloudWatchLogsClient as Client;
use Maxbanton\Cwh\Handler\CloudWatch;

class LogServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $cwClient = $this->app->make('aws')->createClient('CloudWatchLogs');
        $cwGroupName = env('AWS_CWL_GROUP', '');
        $cwStreamNameApp = env('AWS_CWL_APP', '');
        $cwTagName = env('AWS_CWL_TAG_NAME', '');
        $cwTagValue = env('AWS_CWL_TAG_VALUE', '');
        $cwRetentionDays = 90;
        $cwHandlerApp = new CloudWatch($cwClient, $cwGroupName, $cwStreamNameApp, $cwRetentionDays, 10000, [ $cwTagName => $cwTagValue ] );

        $this->app['log']->pushHandler($cwHandlerApp);
    }

    /**
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
