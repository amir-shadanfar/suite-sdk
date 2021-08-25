<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Models\Token;
use Rockads\Suite\Traits\HttpRequest;

/**
 * Class AbstractModule
 * @package Rockads\Suite\Modules
 */
abstract class AbstractModule
{
    use HttpRequest;

    /**
     * @var \Rockads\Suite\Models\Token
     */
    protected Token $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * used in HttpRequest trait
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        return $this->token->getAccessToken();
    }
}
