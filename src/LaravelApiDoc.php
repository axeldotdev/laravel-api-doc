<?php

namespace Axeldotdev\LaravelApiDoc;

use Illuminate\Support\Facades\Artisan;

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
        Artisan::call('route:list --except-vendor --path=api --json');

        $this->routes = new RouteCollection(Artisan::output());
    }

    /**
     * Show the get started view.
     *
     * @return \Illuminate\View\View
     */
    public function getStarted()
    {
        return view('api-doc.get-started');
    }

    /**
     * Show the authentication view.
     *
     * @return \Illuminate\View\View
     */
    public function authentication()
    {
        return view('api-doc.authentication');
    }

    /**
     * Show the errors view.
     *
     * @return \Illuminate\View\View
     */
    public function errors()
    {
        return view('api-doc.errors');
    }

    /**
     * Get the route collection.
     *
     * @return \Axeldotdev\LaravelApiDoc\RouteCollection
     */
    public function routes()
    {
        return $this->routes;
    }

    /**
     * Get the route groups array.
     *
     * @return array
     */
    public function groups()
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
