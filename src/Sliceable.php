<?php

namespace Pianzhou\Sliceable;

use ArrayAccess;
use Closure;
use Illuminate\Support\Collection;

trait Sliceable
{
    /**
     * Slice
     *
     * @param array|Closure|ArrayAccess $ranges
     * @param Closure $callback
     * @return Collection
     */
    public static function slice(array|Closure|ArrayAccess $ranges, Closure $callback)
    {
        if (is_callable($ranges)) {
            $ranges = call_user_func($ranges);
        }

        $models = new Collection();

        foreach ($ranges as $range) {
            $range  = is_array($range) ? $range : [ $range ];
            $models = $models->merge(call_user_func($callback, Static::query() , ...$range));
        }

        return $models;
    }
}
