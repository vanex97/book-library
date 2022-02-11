<?php

namespace Framework\Routing;

class Request
{

    public string $method;
    public string $uri;
    public string $serverProtocol;

    private ?array $jsonData;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->serverProtocol = $_SERVER['SERVER_PROTOCOL'];

        if ($_SERVER['CONTENT_TYPE'] == 'application/json;') {
            $this->jsonData = json_decode(file_get_contents('php://input'), true);
        }
    }

    /**
     * Get params with $_POST.
     * @param $key
     * @return mixed
     */
    public function getPostValue($key): mixed
    {
        if (array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        return null;
    }

    /**
     * Get params with $_GET.
     * @param $key
     * @return mixed
     */
    public function getUriParam($key): mixed
    {
        if (array_key_exists($key, $_GET)) {
            return $_GET[$key];
        }
        return null;
    }

    /**
     * Get json value with key.
     * @param $key
     * @return mixed
     */
    public function getJsonValue($key): mixed
    {
        if (array_key_exists($key, $this->jsonData)) {
            return $this->jsonData[$key];
        }
        return null;
    }
}
