<?php

namespace Axeldotdev\LaravelApiDoc;

use Traversable;
use ArrayIterator;
use IteratorAggregate;

class RouteCollection implements IteratorAggregate
{
    protected array $routes;

    /**
     * Construct the routes collection
     *
     * @param  string $routes
     * @return void
     */
    public function __construct($routes)
    {
        $routes = json_decode($routes);

        foreach ($routes as $index => $route) {
            $route = new Route($route, $index);

            if (in_array("{$route->method}:/{$route->uri}", config('api-doc.excludes'))) {
                continue;
            }

            $this->routes[] = $route;
        }
    }

    /**
     * Find a specific route.
     *
     * @param  string  $path
     * @return \Axeldotdev\LaravelApiDoc\Route
     */
    public function find($path)
    {
        return $this->routes[$path];
    }

    /**
     * Get the routes into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->routes;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->routes);
    }
}
