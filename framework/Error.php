<?php

namespace Framework;

class Error
{
    /**
     * @param $errorCode
     * @param null $errorText
     */
    public static function responseJson($errorCode, $errorText = null)
    {
        http_response_code($errorCode);
        if (!$errorText) {
            $errorText = self::getErrorText($errorCode);
        }
        die(json_encode(["error" => $errorText]));
    }

    /**
     * @param $errorCode
     * @return string|null
     */
    public static function getErrorText($errorCode): ?string
    {
        return match ($errorCode) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
            default => null,
        };
    }
}