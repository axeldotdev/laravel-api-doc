<?php

namespace Axeldotdev\LaravelApiDoc;

use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class LaravelApiDoc
{
    protected RouteCollection $routes;

    /**
     * Construct the object.
     *
     * @return void
     */
    public function __construct()
    {
        $routes = [];

        foreach (config('api-doc.paths') as $path) {
            Artisan::call("route:list --except-vendor --path={$path} --json");

            $routes = array_merge($routes, json_decode(Artisan::output()));
        }

        $this->routes = new RouteCollection($routes);
    }

    /**
     * Show the get started view.
     *
     * @return \Illuminate\View\View
     */
    public function getStarted(): View
    {
        return view('api-doc.get-started');
    }

    /**
     * Show the authentication view.
     *
     * @return \Illuminate\View\View
     */
    public function authentication(): View
    {
        return view('api-doc.authentication');
    }

    /**
     * Show the errors view.
     *
     * @return \Illuminate\View\View
     */
    public function errors(): View
    {
        return view('api-doc.errors');
    }

    /**
     * Get the route collection.
     *
     * @return \Axeldotdev\LaravelApiDoc\RouteCollection
     */
    public function routes(): RouteCollection
    {
        return $this->routes;
    }

    /**
     * Get the route groups array.
     *
     * @return array|\Axeldotdev\LaravelApiDoc\RouteCollection
     */
    public function groups(): array|RouteCollection
    {
        if (count(config('api-doc.groups')) < 1) {
            return $this->routes;
        }

        $groups = [];

        foreach ($this->routes as $index => $route) {
            if (is_null($route->group)) {
                $groups['Misc'][$index] = $route;

                continue;
            }

            $groups[$route->group][$index] = $route;
        }

        return $groups;
    }
}
