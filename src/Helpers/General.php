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

