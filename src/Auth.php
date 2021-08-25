<?php

namespace Rockads\Suite;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\GrantTypes\GrantTypeFactory;
use Rockads\Suite\GrantTypes\GrantTypeInterface;
use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Models\Config;
use Rockads\Suite\Models\Token;
use Rockads\Suite\Traits\HttpRequest;

/**
 * Class Auth
 * @package Rockads\Suite
 */
class Auth
{
    use HttpRequest;

    /**
     * @var \Rockads\Suite\Models\Config
     */
    protected Config $config;

    /**
     * @var \Rockads\Suite\Models\Token|null
     */
    protected ?Token $token = null;

    /**
     * @var array
     */
    protected array $user;

    /**
     * @var string
     */
    protected string $grantType;

    /**
     * @var \Rockads\Suite\GrantTypes\GrantTypeInterface
     */
    protected GrantTypeInterface $grantHandler;

    /**
     * @var string
     */
    protected string $moduleName = 'Auth';

    /**
     * Auth constructor.
     *
     * @param string $authType
     * @param array $configParams
     *
     * @throws \ReflectionException
     */
    public function __construct(string $authType, array $configParams)
    {
        // check config indexed
        if (
            empty($configParams['client_id']) ||
            empty($configParams['client_secret']) ||
            empty($configParams['base_url']) ||
            empty($configParams['api_version'])
        ) {
            throw new \Exception('The given parameters for password grant should not be empty. (client_id | client_secret | base_url | api_version)');
        }
        $this->config = new Config();
        $this->config->setBaseUrl($configParams['base_url']);
        $this->config->setApiVersion($configParams['api_version']);
        $this->config->setClientId($configParams['client_id']);
        $this->config->setClientSecret($configParams['client_secret']);
        if (isset($configParams['params']))
            $this->config->setParams($configParams['params']);
        // check auth type
        if (!in_array($authType, AuthTypes::toArray())) {
            throw new \Exception('The given authentication grant type is invalid');
        }
        $this->grantType = $authType;
        $this->grantHandler = GrantTypeFactory::create($authType, $this->config);
    }

    /**
     * @return \Rockads\Suite\Models\Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return \Rockads\Suite\Models\Token
     */
    public function getToken(): Token
    {
        if (!$this->token instanceof Token) {
            $this->token = $this->grantHandler->getTokens();
        }
        return $this->token;
    }

    /**
     * used in HttpRequest trait
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        return $this->getToken()->getAccessToken();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getUser()
    {
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        return $this->token->getUser();
    }

    /**
     * @param string $accessToken
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getUserByToken(string $accessToken)
    {
        $route = sprintf('api/%s/auth/who-am-i', $this->config->getApiVersion());
        $url = path_join($this->config->getBaseUrl(), $route);

        return $this->withToken($accessToken)
            ->get($url, $this->moduleName);
    }

    /**
     * @param string $customerName
     * @param string $customerWorkspace
     * @param array $customer_services
     * @param string $email
     * @param string $username
     * @param string|null $password
     * @param string|null $name
     * @param string|null $language
     * @param string|null $timezone
     * @param string|null $avatar
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function register(
        string $customerName,
        string $customerWorkspace,
        array $customer_services,
        string $email,
        string $username,
        string $password = null,
        string $name = null,
        string $language = null,
        string $timezone = null,
        string $avatar = null
    )
    {
        $route = sprintf('api/%s/auth/register', $this->config->getApiVersion());
        $url = path_join($this->config->getBaseUrl(), $route);

        return $this->post($url, $this->moduleName, [
            'client_id' => $this->config->getClientId(),
            'client_secret' => $this->config->getClientSecret(),
            // customer
            'customer_name' => $customerName,
            'customer_workspace' => $customerWorkspace,
            'customer_services' => $customer_services,
            // user of customer
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'language' => $language,
            'timezone' => $timezone,
            'avatar' => $avatar,
        ],
            ['avatar' => $avatar]
        );
    }

    /**
     * @param string|null $refreshToken
     *
     * @return \Rockads\Suite\Models\Token|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function refreshToken(string $refreshToken = null)
    {
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // get new token via refresh token
        $route = sprintf('api/%s/auth/refresh-token', $this->config->getApiVersion());
        $url = path_join($this->config->getBaseUrl(), $route);

        $response = $this->post($url, $this->moduleName, [
            'client_id' => $this->config->getClientId(),
            'client_secret' => $this->config->getClientSecret(),
            'refresh_token' => !is_null($refreshToken) ? $refreshToken : $this->token->getRefreshToken(),
        ]);
        // update token object
        $this->token->setAccessToken($response['data']['access_token']);;
        $this->token->setRefreshToken($response['data']['refresh_token']);;
        $this->token->setExpiresIn($response['data']['expires_in']);
        return $this->token;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function resendVerificationEmail()
    {
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // get new token via refresh token
        $route = sprintf('api/%s/auth/email/verification-notification', $this->config->getApiVersion());
        $url = path_join($this->config->getBaseUrl(), $route);

        return $this->withToken($this->token->getAccessToken())
            ->post($url, $this->moduleName);
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function logout()
    {
        // check the token is exist
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // logout
        $route = sprintf('api/%s/auth/logout', $this->config->getApiVersion());
        $url = path_join($this->config->getBaseUrl(), $route);

        return $this->withToken($this->token->getAccessToken())
            ->post($url, $this->moduleName);
    }

}
