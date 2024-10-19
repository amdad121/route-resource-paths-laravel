<?php

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Routing\Route;

class PathsResourceRegistrar extends BaseResourceRegistrar
{
    /**
     * Global paths for resource routes.
     *
     * @var array
     */
    protected static $globalPaths = [];

    /**
     * Global paths for singleton resource routes.
     *
     * @var array
     */
    protected static $globalSingletonPaths = [];

     /**
     * Set global paths for resource routes.
     *
     * @param array $paths
     */
    public static function setGlobalPaths(array $paths): void
    {
        self::$globalPaths = $paths;
    }

    /**
     * Set global paths for singleton resource routes.
     *
     * @param array $paths
     */
    public static function setGlobalSingletonPaths(array $paths): void
    {
        self::$globalSingletonPaths = $paths;
    }

     /**
     * Get the path for a specific resource action, considering both global and specific paths.
     *
     * @param string $action
     * @param array $options
     * @return string
     */
    protected function getResourcePath(string $action, array $options): string
    {
        return $options['paths'][$action] ?? self::$globalPaths[$action] ?? static::$verbs[$action];
    }

     /**
     * Get the path for a specific singleton resource action, considering both global and specific paths.
     *
     * @param string $action
     * @param array $options
     * @return string
     */
    protected function getSingletonResourcePath(string $action, array $options): string
    {
        return $options['paths'][$action] ?? self::$globalSingletonPaths[$action] ?? static::$verbs[$action];
    }

    /**
     * Add the create method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceCreate($name, $base, $controller, $options): Route
    {
        $uri = $this->getResourceUri($name).'/'.$this->getResourcePath('create', $options);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the edit method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceEdit($name, $base, $controller, $options): Route
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.$this->getResourcePath('edit', $options);

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the create method for a singleton route.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addSingletonCreate($name, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/' . $this->getSingletonResourcePath('create', $options);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    /**
     * Add the edit method for a singleton route.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addSingletonEdit($name, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name) . '/' . $this->getSingletonResourcePath('edit', $options);

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }
}
