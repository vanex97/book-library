<?php

namespace Framework\Routing;

use Error;
use Framework\MVC\Controller;
use Framework\MVC\View;

class Router
{
    public const CONTROLLERS_NAMESPACE = 'Src\Controllers\\';

    private const SUPPORTED_HTTP_METHODS = ["GET", "POST"];

    private Request $request;
    private array $routes = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Handles a supported method call from the SUPPORTED_HTTP_METHODS constant.
     * Creates a new route and adds it to the $routes.
     * @param $method
     * @param $args
     * Array with 3 parameters (URI, Controller Name, Controller Method).
     */
    public function __call($method, $args)
    {
        list($uri, $controllerName, $controllerMethod) = $args;

        if (!in_array(strtoupper($method), self::SUPPORTED_HTTP_METHODS)) {
            View::loadError(405);
            return;
        }

        $this->routes[] = new Route($uri, strtoupper($method), $controllerName, $controllerMethod);
    }

    /**
     * Selects the desired route from the request.
     */
    private function resolve()
    {
        $requestUri = $this->request->uri;
        $requestMethod = $this->request->method;

        $route = $this->findRoute($requestUri, $requestMethod);

        if (is_null($route)) {
            View::loadError(404);
            return;
        }

        $params = $route->getUriParam($this->request->uri);
        $this->callController($route, $params);
    }

    /**
     * @param $requestUri
     * @param $requestMethod
     * @return Route|null
     */
    private function findRoute($requestUri, $requestMethod): ?Route
    {
        foreach ($this->routes as $route) {
            $routeUri = $route->uri;
            $routeRegexUri = $route->regexUri;
            $routeMethod = $route->method;

            $isValidRegexUri = $routeRegexUri != null && preg_match($routeRegexUri, $requestUri);
            if ($requestMethod == $routeMethod && $routeUri == $requestUri || $isValidRegexUri) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Calls the controller specified in the route, passing parameters if necessary.
     * @param $route
     * @param $params
     */
    private function callController($route, $params)
    {
        $controllerName = self::CONTROLLERS_NAMESPACE . $route->controllerName;

        if (!class_exists($controllerName)) {
            View::loadError(500);
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $route->controllerMethod)) {
            View::loadError(500);
            return;
        }
        // Send request to router.
        if ($controller instanceof Controller) {
            $controller->setRequest($this->request);
        }

        $controllerMethod = $route->controllerMethod;
        if ($params != null) {
            $controller->$controllerMethod(...$params);
            return;
        }
        try {
            $controller->$controllerMethod();
        } catch (Error) {
            View::loadError(404);
            return;
        }
    }

    public function __destruct()
    {
        $this->resolve();
    }
}
