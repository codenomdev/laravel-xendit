<?php

namespace Codenom\Xendit\Facades;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

class Xendit extends Facade
{
    /**
     * Get the registered name of component.
     * 
     * @return string
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'Xendit';
    }

    /**
     * Handle dynamic, static calls to the object.
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException(
                \sprintf('A facade root has not been set.')
            );
        }

        if (count($args) == 1) {
            return $instance->{$method($args[0])};
        }

        return $instance->$method(...$args);
    }
}
