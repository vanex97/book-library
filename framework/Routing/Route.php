<?php

namespace Framework\Routing;

class Route
{
    public string $uri;
    public ?string $regexUri;
    public string $method;
    public string $controllerName;
    public string $controllerMethod;

    public function __construct($uri, $method, $controllerName, $controllerMethod)
    {
        $this->uri = $this->formatUri($uri);
        $this->regexUri = $this->getRegexUri($this->uri);
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @param $uri
     * @return string
     */
    private function formatUri($uri): string
    {
        if ($uri == '') {
            return '/';
        }
        return $uri;
    }

    /**
     * @param $uri
     * @return string|null
     */
    public function getRegexUri($uri): ?string
    {
        $regex = '/{.+}/';
        if (preg_match($regex, $uri)) {
            $uri = preg_replace('/{\w+}/', '(\w+)', $uri);
            $uri = preg_replace('/\//', '\/', $uri);
            return '/' . $uri . '?$/';
        }
        return null;
    }

    /**
     * @param $requestUri
     * @return array|null
     */
    public function getUriParam($requestUri): ?array
    {
        if ($this->regexUri == null) {
            return null;
        }
        $matches = preg_match($this->regexUri, $requestUri, $parameters);
        if (!$matches) {
            return null;
        }
        return array_slice($parameters, 1);
    }
}
