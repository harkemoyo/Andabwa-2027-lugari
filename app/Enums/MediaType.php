<?php

namespace App\Enums;

enum MediaType: string
{
    case Article = 'article';
    case Image = 'image';
    case LocalVideo = 'local_video';
    case Youtube = 'youtube';
    case ExternalLink = 'external_link';

    public static function uploadTypes(): array
    {
        // Return the raw strings for the form to compare against
        return [
            self::Image->value,
            self::LocalVideo->value,
        ];
    }

    public static function externalTypes(): array
    {
        return [
            self::Youtube->value,
            self::ExternalLink->value,
            self::Article->value,
        ];
    }

    public static function isUploadable(string|self|null $value): bool
    {
        $actualValue = $value instanceof self ? $value->value : $value;

        return in_array($actualValue, [
            self::Image->value,
            self::LocalVideo->value,
        ]);
    }

    public static function isExternal(string|self|null $value): bool
    {
        $actualValue = $value instanceof self ? $value->value : $value;

        return in_array($actualValue, [
            self::Youtube->value,
            self::ExternalLink->value,
            self::Article->value,
        ]);
    }

   
}
