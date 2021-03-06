<?php

namespace CraigWoodlandOW\LaravelMailLogging;

use Illuminate\Support\ServiceProvider;
use Swift_Mailer;
use \Swift_Plugins_LoggerPlugin;
use \Swift_Plugins_MessageLogger;
use CraigWoodlandOW\LaravelMailLogging\SwiftMailServerLogging;
use CraigWoodlandOW\LaravelMailLogging\SwiftMailMessageLogging;

class MailLoggingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
		if(env('SWIFT_MAIL_SERVER_LOG', false)) {
			$this->app->resolving('swift.mailer', function (Swift_Mailer $mailer, $app) {
				$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin(new SwiftMailServerLogging));
			});
		}

        if(env('SWIFT_MAIL_MESSAGE_LOG', false)) {
            $this->app->resolving('swift.mailer', function (Swift_Mailer $mailer, $app) {
                $mailer->registerPlugin(new SwiftMailMessageLogging());
			});
        }
    }
}
