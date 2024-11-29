<?php

namespace Inovector\Appractic\Support;

use Illuminate\Support\Str;
use Spatie\TemporaryDirectory\TemporaryDirectory as BaseTemporaryDirectory;

class MediaTemporaryDirectory
{
    public static function create(): BaseTemporaryDirectory
    {
        return new BaseTemporaryDirectory(static::getTemporaryDirectoryPath());
    }

    protected static function getTemporaryDirectoryPath(): string
    {
        $path = config('appractic.temporary_directory_path') ?? storage_path('appractic-media/temp');

        return $path . DIRECTORY_SEPARATOR . Str::random(32);
    }
}
