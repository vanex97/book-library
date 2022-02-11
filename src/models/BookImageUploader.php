<?php

namespace Src\models;

class BookImageUploader
{
    public const IMG_FOLDER = 'public/images';
    public const ALLOWED_TYPES = ['image/jpeg', 'image/png'];

    private static string $imgRelativePath = __DIR__ . '/../../' . self::IMG_FOLDER;

    /**
     * Uploads an image to the server using the IMG_FOLDER path.
     * @return string|null Added image name or null.
     */
    public static function uploadImage(): ?string
    {
        $fileImage = $_FILES['image']['tmp_name'] ?? null;
        $fileImageName = $_FILES['image']['name'] ?? null;
        if (!$fileImage || !$fileImageName || self::checkImageType($fileImage)) {
            return null;
        }
        var_dump(self::checkImageType($fileImage));

        $uploadImageName = self::getUploadFileName($fileImageName);

        $uploadImage = realpath(self::$imgRelativePath) . '/' . $uploadImageName;
        if ($uploadImageName && move_uploaded_file($fileImage, $uploadImage)) {
            return $uploadImageName;
        }
        return null;
    }

    /**
     * @param $image
     * @return bool
     */
    private static function checkImageType($image): bool
    {
        $imageType = mime_content_type($image);
        return !in_array($imageType, self::ALLOWED_TYPES);
    }

    /**
     * @param $fileImageName
     * @return string
     */
    private static function getUploadFileName($fileImageName): string
    {
        $fileImageName = explode('.', $fileImageName);
        return uniqid('img_') . '.' . $fileImageName[array_key_last($fileImageName)];
    }

}