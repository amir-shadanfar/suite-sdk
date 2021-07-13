<?php

namespace Rockads\Suite\GrantTypes;

use Rockads\Suite\Models\Token;

/**
 * Interface GrantTypeInterface
 * @package Rockads\Suite\GrantTypes
 */
interface GrantTypeInterface
{
    public function getTokens(): Token;
}
