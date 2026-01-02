<?php

declare(strict_types=1);

namespace AmdadulHaq\RouteResourcePathsLaravel;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Routing\Route;

class PathsResourceRegistrar extends BaseResourceRegistrar
{
    protected static $globalPaths = [];

    protected static $globalSingletonPaths = [];

    public static function setGlobalPaths(array $paths): void
    {
        self::$globalPaths = $paths;
    }

    public static function setGlobalSingletonPaths(array $paths): void
    {
        self::$globalSingletonPaths = $paths;
    }

    protected function getResourcePath(string $action, array $options): string
    {
        return $options['paths'][$action] ?? self::$globalPaths[$action] ?? static::$verbs[$action];
    }

    protected function getSingletonResourcePath(string $action, array $options): string
    {
        return $options['paths'][$action] ?? self::$globalSingletonPaths[$action] ?? static::$verbs[$action];
    }

    protected function addResourceCreate($name, $base, $controller, $options): Route
    {
        $uri = $this->getResourceUri($name).'/'.$this->getResourcePath('create', $options);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    protected function addResourceEdit($name, $base, $controller, $options): Route
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.$this->getResourcePath('edit', $options);

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }

    protected function addSingletonCreate($name, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/'.$this->getSingletonResourcePath('create', $options);

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'create', $options);

        return $this->router->get($uri, $action);
    }

    protected function addSingletonEdit($name, $controller, $options)
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/'.$this->getSingletonResourcePath('edit', $options);

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }
}
