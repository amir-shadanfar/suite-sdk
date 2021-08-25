<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Config;
use Rockads\Suite\Models\Token;

/**
 * Class User
 * @package Rockads\Suite\Modules
 */
class User extends AbstractModule
{

    /**
     * @var string
     */
    protected string $moduleName = ModulesType::USER;

    /**
     * @var string
     */
    protected string $url;

    /**
     * User constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Token $token ,Config $config)
    {
        parent::__construct($token);
        $this->url = path_join($config->getBaseUrl(), sprintf('api/%s/users', $config->getApiVersion()));
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function all()
    {
        return parent::get($this->url, $this->moduleName);
    }

    /**
     * @param int $customeId
     * @param array $services
     * @param string $email
     * @param string $username
     * @param string $phone
     * @param int $roleId
     * @param string|null $name
     * @param string|null $password
     * @param string|null $language
     * @param string|null $timezone
     * @param null $avatar
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(
        int $customeId,
        array $services,
        string $email,
        string $username,
        string $phone,
        int $roleId,
        string $name = null,
        string $password = null,
        string $language = null,
        string $timezone = null,
        $avatar = null
    )
    {
        return parent::post($this->url, $this->moduleName, [
            'customer_id' => $customeId,
            'services' => $services,
            'email' => $email,
            'username' => $username,
            'role_id' => $roleId,
            'name' => $name,
            'password' => $password,
            'language' => $language,
            'timezone' => $timezone,
            'avatar' => $avatar,
        ],
            ['avatar' => $avatar]
        );
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function show(int $id)
    {
        return parent::get(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param array $services
     * @param int|null $roleId
     * @param string|null $name
     * @param string|null $phone
     * @param string|null $password
     * @param string|null $language
     * @param string|null $timezone
     * @param null $avatar
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(
        int $id,
        array $services = [],
        int $roleId = null,
        string $name = null,
        string $phone = null,
        string $password = null,
        string $language = null,
        string $timezone = null,
        $avatar = null
    )
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'services' => $services,
            'role_id' => $roleId,
            'name' => $name,
            'phone' => $phone,
            'password' => $password,
            'language' => $language,
            'timezone' => $timezone,
            'avatar' => $avatar,
        ],
            ['avatar' => $avatar]
        );
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function destroy(int $id)
    {
        return parent::delete(path_join($this->url, $id), $this->moduleName);
    }

}
