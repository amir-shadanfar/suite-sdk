<?php

namespace Rockads\Suite\Models;

use Carbon\Carbon;

/**
 * Class Token
 * @package Rockads\Suite\Models
 */
class Token
{
    /**
     * @var string
     */
    protected string $tokenType;

    /**
     * @var string
     */
    protected string $accessToken;

    /**
     * @var string
     */
    protected string $refreshToken;

    /**
     * @var \DateTime
     */
    protected \DateTime $expiresIn;

    /**
     * @var array
     */
    protected array $user = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if ($this->valid($data)) {
            $this->setTokenType($data['data']['token']['token_type']);
            $this->setAccessToken($data['data']['token']['access_token']);
            $this->setRefreshToken($data['data']['token']['refresh_token']);
            $this->setExpiresIn($data['data']['token']['expires_in']);
            // in m2m grant type user is null
            unset($data['data']['token']);
            $this->setUser($data['data']);
        }
    }

    /**
     * @param array $data
     *
     * @return false
     */
    private function valid(array $data = [])
    {
        $tokenInfo = $data['data']['token'];

        if (count($tokenInfo) < 1)
            return false;

        if (!isset($tokenInfo['token_type']) || !isset($tokenInfo['access_token']) || !isset($tokenInfo['refresh_token']) || !isset($tokenInfo['expires_in']))
            return false;

        return true;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = Carbon::now()
            ->addSeconds($expiresIn)
            // ->setTimezone()
            ->toDateTime();
    }


    /**
     * @param string $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }


    /**
     * @param array $user
     */
    public function setUser(array $user): void
    {
        $this->user = $user;
    }

}
