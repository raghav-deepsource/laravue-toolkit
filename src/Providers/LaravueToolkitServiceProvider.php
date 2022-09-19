<?php

namespace Laravue\Providers;

use const DIRECTORY_SEPARATOR;
use Illuminate\Foundation\Application;
use Laravue\Commands\Deploy\ComposerUpdateCommand;
use Laravue\Commands\Deploy\GitPullCommand;
use Laravue\Commands\Deploy\NpmUpdateCommand;
use Laravue\Commands\Deploy\ViteBuildCommand;
use Laravue\Commands\LaravueToolkitCommand;
use Laravue\Enums\CurrencyFormat;
use Laravue\Utility\Number;
use Laravue\Utility\ServerInfo;
use Laravue\Utility\Text;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravueToolkitServiceProvider extends PackageServiceProvider
{
    /**
     * @param  \Spatie\LaravelPackageTools\Package  $package
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravue-toolkit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravue-toolkit_table')
            ->hasCommands([
                LaravueToolkitCommand::class,
            ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('utility.number', function (Application $app) {
            return new Number($app->currentLocale(), CurrencyFormat::DEFAULT, 'BRL');
        });
        $this->app->bind('utility.server_info', function (Application $app) {
            return new ServerInfo();
        });
        $this->app->bind('utility.text', function (Application $app) {
            return new Text();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $langPath = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($langPath, 'laravue');

        $this->publishes([
            $langPath => $this->app->langPath('vendor/laravue'),
        ], 'laravue-toolkit-lang');

        $this->commands([
            LaravueToolkitCommand::class,
            ComposerUpdateCommand::class,
            GitPullCommand::class,
            NpmUpdateCommand::class,
            ViteBuildCommand::class,
        ]);
    }
}
