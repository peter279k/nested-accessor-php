<?php

namespace Smoren\NestedAccessor\Helpers;

use Smoren\NestedAccessor\Components\NestedAccessor;
use Smoren\NestedAccessor\Exceptions\NestedAccessorException;

/**
 * Helper for getting and setting to source array or object with nested keys
 * @author Smoren <ofigate@gmail.com>
 */
class NestedHelper
{
    /**
     * @var NestedAccessor|null nested accessor instance
     */
    protected static ?NestedAccessor $accessor = null;

    /**
     * Gets value from nested source by given path
     * @param array<scalar, mixed>|object $source source
     * @param string|array<string> $path path e.g. 'path.to.value' or ['path', 'to', 'value']
     * @param bool $strict if true: throw exception when path is not found in source
     * @return mixed value got by path
     * @throws NestedAccessorException
     */
    public static function get($source, $path, bool $strict = true)
    {
        return static::prepareAccessor($source)->get($path, $strict);
    }

    /**
     * Sets value to nested source by given path
     * @param array<scalar, mixed>|object $source source
     * @param string|array<string> $path path e.g. 'path.to.value' or ['path', 'to', 'value']
     * @param mixed $value value to set
     * @param bool $strict if true: throw exception when path is not found in source
     * @return void
     * @throws NestedAccessorException
     */
    public static function set(&$source, $path, $value, bool $strict = true): void
    {
        static::prepareAccessor($source)->set($path, $value, $strict);
    }

    /**
     * Method for preparing accessor to use with source
     * @param array<scalar, mixed>|object $source source data
     * @return NestedAccessor
     * @throws NestedAccessorException
     */
    protected static function prepareAccessor(&$source): NestedAccessor
    {
        if(static::$accessor === null) {
            static::$accessor = new NestedAccessor($source);
        } else {
            static::$accessor->setSource($source);
        }

        return static::$accessor;
    }
}
