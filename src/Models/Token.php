<?php

namespace Rockads\Suite\Models;

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
     * @var int
     */
    protected int $expiresIn;

    /**
     * @var array
     */
    protected array $user = [];

    /**
     * @var \Rockads\Suite\Models\Config
     */
    protected Config $config;

    /**
     * Token constructor.
     *
     * @param array $data
     * @param \Rockads\Suite\Models\Config $config
     *
     * @throws \Exception
     */
    public function __construct(array $data, Config $config)
    {
        $this->config = $config;
        // validation token data
        if ($this->valid($data)) {
            $this->setTokenType($data['token_type']);
            $this->setAccessToken($data['access_token']);
            $this->setExpiresIn($data['expires_in']);
            // client_credential: refreshToken not set
            if (isset($data['refresh_token'])) {
                $this->setRefreshToken($data['refresh_token']);
                unset($data['refresh_token']);
            }
            // in m2m grant type user is null
            unset($data['token_type']);
            unset($data['access_token']);
            unset($data['expires_in']);
            $this->setUser($data['data']);
        }
    }

    /**
     * @param array $data
     *
     * @return false
     */
    private function valid(array $tokenInfo = [])
    {
        if (count($tokenInfo) < 1 || !isset($tokenInfo['token_type']) || !isset($tokenInfo['access_token']) || !isset($tokenInfo['expires_in']))
            return false;

        return true;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
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
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     *
     * @throws \Exception
     */
    public function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = time() + $expiresIn;
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
