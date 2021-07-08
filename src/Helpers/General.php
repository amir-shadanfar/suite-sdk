<?php

/**
 * join two string with slash
 */
if (!function_exists('path_join')) {
    function path_join(string $base, string $path)
    {
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('camel_to_snake')) {
    function camel_to_snake($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}

if (!function_exists('snakeToCamel')) {
    function snakeToCamel($input)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }
}