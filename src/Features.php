<?php

namespace Axeldotdev\LaravelApiDoc;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('api-doc.features', []));
    }

    /**
     * Enable the authentication view feature.
     *
     * @return string
     */
    public static function authentication()
    {
        return 'authentication';
    }

    /**
     * Enable the generated example feature on routes.
     *
     * @return string
     */
    public static function generatedExample()
    {
        return 'generated-example';
    }

    /**
     * Enable the generated documentation feature.
     *
     * @return string
     */
    public static function generatedDocumentation()
    {
        return 'generated-documentation';
    }
}
