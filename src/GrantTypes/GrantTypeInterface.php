<?php

namespace Suite\Suite\GrantTypes;

use Suite\Suite\Models\Token;

/**
 * Interface GrantTypeInterface
 * @package Suite\Suite\GrantTypes
 */
interface GrantTypeInterface
{
    public function getTokens(): Token;
}
