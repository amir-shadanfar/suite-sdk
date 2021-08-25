<?php

namespace Rockads\Suite\GrantTypes;

use Rockads\Suite\Traits\HttpRequest;

/**
 * Class AbstractGrantType
 * @package Rockads\Suite\GrantTypes
 */
abstract class AbstractGrantType implements GrantTypeInterface
{
    use HttpRequest;
}
