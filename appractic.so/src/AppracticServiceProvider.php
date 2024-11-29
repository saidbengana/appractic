<?php

namespace Inovector\Appractic;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Gate;
use Inovector\Appractic\Commands\ClearServicesCache;
use Inovector\Appractic\Commands\ClearSettingsCache;
use Inovector\Appractic\Commands\CreateMastodonApp;
use Inovector\Appractic\Commands\DeleteOldData;
use Inovector\Appractic\Commands\ImportAccountAudience;
use Inovector\Appractic\Commands\ProcessMetrics;
use Inovector\Appractic\Commands\PublishAssetsCommand;
use Inovector\Appractic\Commands\ImportAccountData;
use Inovector\Appractic\Commands\RunScheduledPosts;
use Inovector\Appractic\Exceptions\AppracticExceptionHandler;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AppracticServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('appractic')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasMigrations([
                'create_appractic_services_table',
                'create_appractic_accounts_table',
                'create_appractic_posts_table',
                'create_appractic_post_accounts_table',
                'create_appractic_post_versions_table',
                'create_appractic_tags_table',
                'create_appractic_tag_post_table',
                'create_appractic_media_table',
                'create_appractic_settings_table',
                'create_appractic_imported_posts_table',
                'create_appractic_facebook_insights_table',
                'create_appractic_metrics_table',
                'create_appractic_audience_table',
            ])
            ->hasCommands([
                PublishAssetsCommand::class,
                CreateMastodonApp::class,
                ClearSettingsCache::class,
                ClearServicesCache::class,
                RunScheduledPosts::class,
                ImportAccountAudience::class,
                ImportAccountData::class,
                ProcessMetrics::class,
                DeleteOldData::class
            ])->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $this->writeSeparationLine($command);
                        $command->line('Appractic Installation. Self-hosted social media management software.');
                        $command->line('Laravel version: ' . app()->version());
                        $command->line('PHP version: ' . trim(phpversion()));
                        $command->line(' ');
                        $command->line('Github: https://github.com/inovector/appractic');
                        $this->writeSeparationLine($command);
                        $command->line('');

                        $command->comment('Publishing assets');
                        $command->call('appractic:publish-assets');
                    })
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('inovector/appractic')
                    ->endWith(function (InstallCommand $command) {
                        $appUrl = config('app.url');

                        $command->line("Visit the Appractic UI at $appUrl/appractic");
                    });
            });
    }

    public function packageRegistered()
    {
        $this->app->singleton('AppracticSocialProviderManager', function ($app) {
            return new SocialProviderManager($app);
        });

        $this->app->singleton('AppracticSettings', function ($app) {
            return new Settings($app);
        });

        $this->app->singleton('AppracticServices', function ($app) {
            return new Services($app);
        });
    }

    public function packageBooted()
    {
        $this->registerExceptionHandler();

        Gate::define('viewAppractic', function () {
            return true;
        });
    }

    protected function registerExceptionHandler(): void
    {
        app()->bind(ExceptionHandler::class, AppracticExceptionHandler::class);
    }

    protected function writeSeparationLine(InstallCommand $command): void
    {
        $command->info('*---------------------------------------------------------------------------*');
    }
}
