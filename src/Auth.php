<?php

namespace Rockads\Suite;

use Illuminate\Support\Facades\Http;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\GrantTypes\GrantTypeFactory;
use Rockads\Suite\GrantTypes\GrantTypeInterface;
use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Models\Token;

/**
 * Class Auth
 * @package Rockads\Suite
 */
class Auth
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * @var string
     */
    protected string $clientId;

    /**
     * @var string
     */
    protected string $clientSecret;

    /**
     * @var array
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
     * Auth constructor.
     *
     * @param string $authType
     * @param array $configParams
     *
     * @throws \ReflectionException
     */
    public function __construct(string $authType, array $configParams = [])
    {
        // get config singleton
        $config = Config::getInstance();

        $this->baseUrl = $config->get('base_url');
        $this->apiVersion = $config->get('api_version');
        $this->clientId = $config->get('auth.client_id');
        $this->clientSecret = $config->get('auth.client_secret');
        // check auth type
        if (!in_array($authType, AuthTypes::toArray())) {
            throw new \Exception('The given authentication grant type is invalid');
        }
        $this->grantType = $authType;
        $this->grantHandler = GrantTypeFactory::create($authType, $configParams);
    }

    /**
     * @return array|\Rockads\Suite\Models\Token
     */
    public function getToken()
    {
        if (!$this->token instanceof Token) {
            $this->token = $this->grantHandler->getTokens();
        }
        return $this->token;
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
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getUserByToken(string $accessToken)
    {
        // get user by token
        $route = sprintf('api/%s/auth/who-am-i', $this->apiVersion);
        $url = path_join($this->baseUrl, $route);
        $response = Http::acceptJson()
            ->withToken($accessToken)
            ->get($url);
        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling user by token" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
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
     * @return array|mixed
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
        $route = sprintf('api/%s/auth/register', $this->apiVersion);
        $url = path_join($this->baseUrl, $route);
        $response = Http::acceptJson()
            ->post($url, [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
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
            ]);
        
        if ($response->status() == 201) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling register" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string|null $refreshToken
     *
     * @return array|\Rockads\Suite\Models\Token|null
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function refreshToken(string $refreshToken = null)
    {
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // get new token via refresh token
        $route = sprintf('api/%s/auth/refresh-token', $this->apiVersion);
        $url = path_join($this->baseUrl, $route);
        $response = Http::acceptJson()
            ->post($url, [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => !is_null($refreshToken) ? $refreshToken : $this->token->getRefreshToken(),
            ]);

        if ($response->ok()) {
            $this->token->setAccessToken($response['data']['access_token']);;
            $this->token->setRefreshToken($response['data']['refresh_token']);;
            $this->token->setExpiresIn($response['data']['expires_in']);
            return $this->token;
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling refresh token" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function resendVerificationEmail()
    {
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // get new token via refresh token
        $route = sprintf('api/%s/auth/email/verification-notification', $this->apiVersion);
        $url = path_join($this->baseUrl, $route);
        $response = Http::acceptJson()
            ->withToken($this->token->getAccessToken())
            ->post($url);

        if ($response->ok()) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling verification email" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function logout()
    {
        // check the token is exist
        if (!$this->token instanceof Token)
            throw new \Exception('Token was not set, try to get token method');
        // logout
        $route = sprintf('api/%s/auth/logout', $this->apiVersion);
        $url = path_join($this->baseUrl, $route);
        $response = Http::acceptJson()
            ->withToken($this->token->getAccessToken())
            ->post($url);

        if ($response->ok()) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in logout" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

}
