<?php

namespace Needletail\Helpers;

use function trigger_error;

use const E_USER_DEPRECATED;

abstract class DeprecationHelper
{

    /**
     * @param  string  $method
     * @param  string  $replacement
     */
    public static function trigger(string $method, string $replacement): void
    {
        trigger_error("Method '{$method}' is deprecated use '{$replacement}' instead", E_USER_DEPRECATED);
    }
}