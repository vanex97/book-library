<?php

namespace Framework\MVC;

use Framework\Error;

class View
{
    private const TEMPLATE_PATH_NAME = 'templates';

    /**
     * @param $templateFileName
     * @param array $variables
     */
    public static function load($templateFileName, array $variables = [])
    {
        $template = self::getTemplatePath() . '/' . $templateFileName;

        // Check template exists.
        if (!file_exists($template)) {
            self::loadError(500);
            return;
        }
        extract($variables);

        include $template;
    }

    /**
     * @param $errorCode
     * @param null $errorText
     */
    public static function loadError($errorCode, $errorText = null)
    {
        $template = self::getTemplatePath() . '/error.php';

        if (!$errorText) {
            $errorText = Error::getErrorText($errorCode);
        }

        if (file_exists($template)) {
            include $template;
        }

        http_response_code($errorCode);
    }

    /**
     * @return bool|string
     */
    private static function getTemplatePath(): bool|string
    {
        return realpath(__DIR__ . '/../../' . self::TEMPLATE_PATH_NAME);
    }
}
