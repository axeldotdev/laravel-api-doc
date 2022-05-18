<?php

use Axeldotdev\LaravelApiDoc\Features;

return [
    /*
    |--------------------------------------------------------------------------
    | API Doc Domain
    |--------------------------------------------------------------------------
    |
    | This is the subdomain where API Doc will be accessible from. If this
    | setting is null, Horizon will reside under the same domain as the
    | application. Otherwise, this value will serve as the subdomain.
    |
    */

    'domain' => env('API_DOC_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | API Doc Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where API Doc will be accessible from. Feel free
    | to change this path to anything you like. Note that the URI will not
    | affect the paths of its internal API that aren't exposed to users.
    |
    */

    'path' => env('API_DOC_PATH', 'doc'),

    /*
    |--------------------------------------------------------------------------
    | API Doc Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every API Doc route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can just stick with this stack.
    |
    */

    'middleware' => [
        'web' => [
            'auth',
        ],

        'api' => [
            'App\Http\Middleware\Authenticate:sanctum',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes paths
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to specify the routes paths
    | that you want to include on the doc. It can be useful
    | to hide some internal routes for example.
    |
    | Example: ['api/v1'] ==> ['{route_path}']
    |
    */

    'paths' => [
        'api/v1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes to exclude
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to specify the routes uri
    | that you want to exclude from the doc. It can be useful
    | to hide some internal routes for example.
    |
    | Example: ['GET:/api/v1/users'] ==> ['{METHOD_HTTP}:{route_path}']
    |
    */

    'excludes' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Versions
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to specify the API versions and
    | there path. It allow the doc to filter and show only one version
    | at a time.
    |
    | Example: ['Version 1' => '/api/v1'] ==> [{Name to show} => {path}]
    |
    */

    'versions' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to specify the groups of your
    | routes versions and structure the menu of the doc.
    |
    | Example: ['Users' => '/users'] ==> [{Name to show} => {path}]
    |
    */

    'groups' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to customize the examples languages
    | of the API Doc interface. Currently, we only support curl, php
    | and javascript.
    |
    */

    'languages' => [
        'curl',
        'php',
        'javascript',
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | These configuration values allow you to customize the branding of the
    | API Doc interface, including the primary color and the logo that will
    | be displayed within the API Doc interface. This logo value must be
    | the absolute path to an SVG logo within the local filesystem.
    |
    */

    'brand' => [
        'logo' => realpath(__DIR__ . '/../public/svg/logo.svg'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of the API Doc features are optional. You may disable the features
    | by removing them from this array. You're free to only remove some of
    | these features or you can even remove all of these if you need to.
    |
    */

    'features' => [
        Features::authentication(),
        Features::generatedExample(),
        // Features::generatedDocumentation(),
    ],
];
