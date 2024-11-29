<?php

namespace Inovector\Appractic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array form()
 * @method static array rules()
 * @method static get(string $name)
 * @method static getFromCache(string $name, mixed $default = null)
 * @method static array all()
 * @method static void forget(string $name)
 * @method static void forgetAll()
 * @method static void put(string $name, mixed $default = null)
 *
 * @see \Inovector\Appractic\Settings
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AppracticSettings';
    }
}
