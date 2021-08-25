<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Config;
use Rockads\Suite\Models\Token;

/**
 * Class Application
 * @package Rockads\Suite\Modules
 */
class Application extends AbstractModule
{
    /**
     * @var string
     */
    protected string $moduleName = ModulesType::APPLICATION;

    /**
     * @var string
     */
    protected string $url;

    /**
     * Application constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Token $token, Config $config)
    {
        parent::__construct($token);
        $this->url = path_join($config->getBaseUrl(), sprintf('api/%s/applications', $config->getApiVersion()));
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
     * @param string $name
     * @param string $platform
     * @param string $bundleId
     * @param null $icon
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(string $name, string $platform, string $bundleId, $icon = null)
    {
        return parent::post($this->url, $this->moduleName, [
            'name' => $name,
            'platform' => $platform,
            'bundle_id' => $bundleId,
            'icon' => $icon,
        ],
            ['icon' => $icon]
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
     * @param string|null $name
     * @param string|null $platform
     * @param string|null $bundleId
     * @param null $icon
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name = null, string $platform = null, string $bundleId = null, $icon = null)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
            'platform' => $platform,
            'bundle_id' => $bundleId,
            'icon' => $icon,
        ],
            ['icon' => $icon]
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
