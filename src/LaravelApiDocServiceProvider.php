<?php

namespace Axeldotdev\LaravelApiDoc;

use Axeldotdev\LaravelApiDoc\Commands\GenerateApiDoc;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelApiDocServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-api-doc')
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasViews()
            ->hasAssets()
            ->hasViewComponent('api-doc', 'layout')
            ->hasViewComponent('api-doc', 'header')
            ->hasViewComponent('api-doc', 'nav')
            ->hasViewComponent('api-doc', 'content')
            ->hasViewComponent('api-doc', 'code')
            ->hasViewComponent('api-doc', 'heading')
            ->hasViewComponent('api-doc', 'section')
            ->hasViewComponent('api-doc', 'shiki')
            ->hasViewComponent('api-doc', 'table')
            ->hasViewComponent('api-doc', 'table-row')
            ->hasViewComponent('api-doc', 'table-column')
            ->hasViewComponent('api-doc', 'tag')
            ->hasCommand(GenerateApiDoc::class);
    }
}
