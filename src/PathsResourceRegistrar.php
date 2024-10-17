<?php

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Routing\Route;

class PathsResourceRegistrar extends BaseResourceRegistrar
{
    /**
     * Add the create method route with a custom path if specified.
     */
    protected function addResourceCreate($name, $base, $controller, $options): Route
    {
        $uri = $this->getResourceUri($name).'/'.($options['paths']['create'] ?? static::$verbs['create']);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the edit method route with a custom path if specified.
     */
    protected function addResourceEdit($name, $base, $controller, $options): Route
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.($options['paths']['edit'] ?? static::$verbs['edit']);

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }
}
