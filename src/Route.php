<?php

namespace Axeldotdev\LaravelApiDoc;

use ReflectionClass;
use ReflectionNamedType;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class Route
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    /**
     * The route index in the collection.
     *
     * @var int
     */
    public $index;

    /**
     * The route domain.
     *
     * @var string|null
     */
    public $domain;

    /**
     * The route HTTP method.
     *
     * @return string
     */
    public $method;

    /**
     * The route group.
     *
     * @return string
     */
    public $group;

    /**
     * The route uri.
     *
     * @return string
     */
    public $uri;

    /**
     * The route short uri.
     *
     * @return string
     */
    public $short_uri;

    /**
     * The route name.
     *
     * @return string|null
     */
    public $name;

    /**
     * The route action (class and method).
     *
     * @return array<int, string>
     */
    public $action;

    /**
     * The route controller class name.
     *
     * @return string-class
     */
    public $class_name;

    /**
     * The route controller method.
     *
     * @return string
     */
    public $class_method;

    /**
     * The route middleware.
     *
     * @return array<int, string>
     */
    public $middleware;

    /**
     * The route authentication need.
     *
     * @return bool
     */
    public $guarded;

    /**
     * The route description from the controller method.
     *
     * @return string|null
     */
    public $description;

    /**
     * The route uri params.
     *
     * @return \Illuminate\Support\Collection
     */
    public $uri_params;

    /**
     * The route query params.
     *
     * @return \Illuminate\Support\Collection
     */
    public $query_params;

    /**
     * The route response fields.
     *
     * @var \Illuminate\Support\Collection
     */
    public $response_fields;

    /**
     * The route related model.
     *
     * @return array<int, string-class>
     */
    public $models;

    /**
     * The route view with the content and the examples.
     *
     * @var \Illuminate\View\View
     */
    public $view;

    /**
     * Construct the route.
     *
     * @param  \stdClass  $route
     * @param  int  $index
     * @return void
     */
    public function __construct($route, $index)
    {
        $this->index = $index;
        $this->domain = $route->domain;
        $this->method = $this->determineMethod($route);
        $this->uri = $route->uri;
        $this->short_uri = Str::replace(array_merge(config('api-doc.versions'), []), '', "/{$route->uri}");
        $this->name = $route->name;
        $this->action = explode('@', $route->action);
        $this->class_name = $this->action[0];
        $this->class_method = $this->action[1];
        $this->middleware = $route->middleware;
        $this->uri_params = new Collection();
        $this->query_params = new Collection();
        $this->response_fields = new Collection();

        $method = (new ReflectionClass($this->class_name))->getMethod($this->class_method);

        $this->formatDescription($method->getDocComment());
        $this->determineAuthentication();
        $this->determineGroup();
        $this->determineUriParams($method->getParameters());
        $this->determineQueryParams($method->getParameters());
        $this->determineResponseFields($method->getReturnType());
        $this->determineModels($method->getParameters());
        $this->determineView();
    }

    protected function determineMethod($route)
    {
        $methods = explode('|', $route->method);
        $methods = array_filter($methods, fn ($m) => $m !== 'HEAD');

        return reset($methods);
    }

    /**
     * Format the route description.
     *
     * @param  string  $description
     * @return void
     */
    protected function formatDescription($description)
    {
        $this->description = Str::of($description)
            ->replace("/**\n", '')
            ->replace("*\n", '')
            ->replace('* ', '')
            ->replace('*/', '')
            ->replace("\n", '')
            ->before('@return')
            ->before('@param')
            ->replaceMatches('/\s{2,}/', ' ')
            ->trim()
            ->toString();
    }

    /**
     * Determine if the route is guarded.
     *
     * @return void
     */
    protected function determineAuthentication()
    {
        if (! $this->middleware) {
            $this->guarded = false;
        }

        $this->guarded = count(array_filter(
            $this->middleware,
            fn ($middleware) => in_array($middleware, config('api-doc.middleware.auth', [
                'App\Http\Middleware\Authenticate:sanctum',
            ])),
        )) > 0;
    }

    /**
     * Determine the route group.
     *
     * @return void
     */
    protected function determineGroup()
    {
        foreach (config('api-doc.groups') as $name => $path) {
            if (Str::startsWith($this->short_uri, $path)) {
                $this->group = $name;

                return;
            }
        }

        $this->group = null;
    }

    /**
     * Determine the route uri params.
     *
     * @param  array  $params
     * @return void
     */
    protected function determineUriParams(array $params)
    {
        if (! $params) {
            return;
        }

        foreach ($params as $param) {
            $class_name = $param->getType()->getName();
            $reflection = new ReflectionClass($class_name);
            $is_request = $reflection->getParentClass() && in_array($reflection->getParentClass()->getName(), [
                'Illuminate\Foundation\Http\FormRequest',
            ]);
            $is_model = $reflection->getParentClass() && in_array($reflection->getParentClass()->getName(), [
                'Illuminate\Database\Eloquent\Model',
                'Illuminate\Foundation\Auth\User',
            ]);

            $uri_type = $param->getType()->getName();

            if ($is_model) {
                $uri_type = (new $uri_type())->getKeyType();
            }

            $this->uri_params->push((object) [
                'name' => $param->getName(),
                'type' => $param->getType()->getName(),
                'uri_type' => $uri_type,
                'required' => ! $param->getType()->allowsNull(),
                'values' => '',
                'is_request' => $is_request,
                'is_model' => $is_model,
            ]);
        }
    }

    /**
     * Determine the route query params.
     *
     * @return void
     */
    protected function determineQueryParams(array $params)
    {
        if (! $params) {
            return;
        }

        $request_params = array_filter(
            $params,
            fn ($param) => ! $param->getType()->isBuiltin(),
        );

        foreach ($request_params as $param) {
            $class_name = $param->getType()->getName();
            $reflection = new ReflectionClass($class_name);

            if ($reflection->getParentClass() && in_array($reflection->getParentClass()->getName(), [
                'Illuminate\Foundation\Http\FormRequest',
            ])) {
                $request = new $class_name();
                $rules = $request->rules();

                foreach ($rules as $name => $rules) {
                    $rules = array_map(function ($rule) {
                        return str_replace('"', '', $rule);
                    }, $rules);

                    $type = $this->determineRequestParamType($rules);
                    $required = in_array('required', $rules)
                        || in_array('required_if', $rules)
                        || in_array('required_unless', $rules)
                        || in_array('required_with', $rules)
                        || in_array('required_without', $rules)
                        || in_array('required_without_all', $rules)
                        || in_array('required_array_keys', $rules)
                        || in_array('required_unless', $rules)
                        || in_array('sometimes', $rules);
                    $values = '';

                    $this->query_params->push((object) compact(
                        'name',
                        'type',
                        'required',
                        'values',
                        'rules',
                    ));
                }
            }
        }
    }

    /**
     * Determine the route response fields.
     *
     * @return void
     */
    protected function determineResponseFields(?ReflectionNamedType $return = null)
    {
        if (is_null($return)) {
            return;
        }

        $class_name = $return->getName();
        $reflection = new ReflectionClass($class_name);

        if ($reflection->getParentClass() && in_array($reflection->getParentClass()->getName(), [
            'Illuminate\Database\Eloquent\Model',
            'Illuminate\Foundation\Auth\User',
        ])) {
            $model = new $class_name();
            $hidden_property = $reflection->getProperty('hidden');
            $hidden_property->setAccessible(true);
            $hidden_fields = $hidden_property->getValue($model);
            $fields = Schema::getColumnListing($model->getTable());
            $fields = array_filter($fields, fn ($field) => ! in_array($field, $hidden_fields));

            $this->response_fields = new Collection(array_map(fn ($field) => (object) [
                'name' => $field,
                'type' => Schema::getColumnType($model->getTable(), $field),
                'nullable' => ! Schema::getConnection()->getDoctrineColumn($model->getTable(), $field)->getNotnull(),
                'values' => '',
            ], $fields));
        }
    }

    protected function determineRequestParamType(array $rules)
    {
        $type = 'string';

        foreach ($rules as $rule) {
            if ($rule === 'string'
                || $rule === 'password'
                || $rule === 'timezone'
                || $rule === 'ip'
                || $rule === 'ipv4'
                || $rule === 'ipv6'
                || $rule === 'json'
                || $rule === 'mac_address'
                || $rule === 'url'
                || $rule === 'uuid'
                || $rule === 'date'
                || $rule === 'active_url'
                || $rule === 'alpha'
                || $rule === 'alpha_dash'
                || $rule === 'alpha_num'
                || Str::startsWith($rule, 'email')) {
                $type = 'string';

                break;
            }

            if ($rule === 'array') {
                $type = 'array';

                break;
            }

            if ($rule === 'accepted'
                || Str::startsWith($rule, 'accepted_if')
                || $rule === 'confirmed'
                || $rule === 'declined'
                || Str::startsWith($rule, 'declined_if')
                || $rule === 'boolean') {
                $type = 'boolean';

                break;
            }

            if (Str::startsWith($rule, 'digits')
                || $rule === 'decimal'
                || $rule === 'integer'
                || $rule === 'numeric'
                || Str::startsWith($rule, 'dimensions')) {
                $type = 'float';

                break;
            }

            if ($rule === 'file'
                || $rule === 'image') {
                $type = 'file';

                break;
            }
        }

        return $type;
    }

    /**
     * Determine the route related models.
     *
     * @param  array  $params
     * @return void
     */
    protected function determineModels(array $params)
    {
        if (! $params) {
            return;
        }

        $class_params = array_filter(
            $params,
            fn ($param) => ! $param->getType()->isBuiltin(),
        );

        foreach ($class_params as $param) {
            $reflection = new ReflectionClass($param->getType()->getName());

            if (in_array($reflection->getParentClass()->getName(), [
                'Illuminate\Foundation\Auth\User',
                'Illuminate\Database\Eloquent\Model',
            ])) {
                $this->models[] = $param->getType()->getName();
            }
        }
    }

    /**
     * Determine the route view.
     *
     * @return void
     */
    protected function determineView()
    {
        [$group, $method] = explode('.', $this->name);

        if (file_exists(resource_path("api-doc.{$group}.{$method}"))) {
            $this->view = view("api-doc.{$group}.{$method}", [
                'route' => $this,
            ]);
        }

        $this->view = view('api-doc::route', [
            'route' => $this,
        ]);
    }
}
