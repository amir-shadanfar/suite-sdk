<?php

use Illuminate\Support\Facades\Cache;
use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

const TOKEN_KEY = "suite_auth_token";

try {
    // get token from cache
    if (Cache::has(TOKEN_KEY)) {
        return Cache::get(TOKEN_KEY);
    }
    
    // 1.user-based auth---------------------
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'base_url' => 'http://suite.rockads.mobylonia.com',
        'api_version' => 'v1',
        'client_id' => '1',
        'client_secret' => 'qdFMCWXAGN4VFHqPJuMGMXTOmJwJpQo8IKRvcAzb',
        // params
        'params' => [
            'username' => 'user@example.com',
            'password' => '123!@#asd',
            'workspace' => 'workspace_one',
            // ...
        ]
    ]);
    // 2.machine-based(m2m) auth-------------
    // $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::CLIENT_CREDENTIALS);
    
    $token = $suiteAuth->getToken();
    // cache token for feature uses
    $cachePeriod = $token->getExpiresIn() - strtotime('now');
    Cache::put(
        TOKEN_KEY,
        $token,
        $cachePeriod
    );
    return $token;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
