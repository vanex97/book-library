<?php

namespace Src\models;

class BookFormValidator
{
    public const MAX_BOOK_AUTHORS = 3;
    public const REQUIRED_KEYS = ['name', 'authors', 'year'];

    /**
     * @param $request
     * @return bool
     */
    public static function checkRequiredKeys($request): bool
    {
        // Check req keys
        foreach (self::REQUIRED_KEYS as $key) {
            if ($request->getPostValue($key) === null) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validates a list of authors from forms.
     * @param $request
     * @return array|null a filtered list
     */
    public static function getAuthors($request): ?array
    {
        $authorsNames = $request->getPostValue('authors');
        if (!is_array($authorsNames)) {
            return null;
        }
        $authorsNames = array_filter($authorsNames);
        if ($authorsNames == null || count($authorsNames) > self::MAX_BOOK_AUTHORS) {
            return null;
        }
        return $authorsNames;
    }
}