<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

include_once '../../../../../vendor/autoload.php';

const TOKEN_KEY = "suite_auth_token";

try {
    // get token from cache
    if (Cache::has(self::TOKEN_KEY)) {
        return Cache::get(self::TOKEN_KEY);
    }
    
    // 1.user-based auth---------------------
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'username' => 'admin@example.com',
        'password' => '123',
        'workspace' => 'teknasyon',
    ]);
    // 2.machine-based(m2m) auth-------------
    // $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::CLIENT_CREDENTIALS);
    
    $token = $suiteAuth->getToken();
    // cache token for feature uses
    $now = new \DateTime('now');
    $date = $token->getExpiresIn();
    $cachePeriod = $date->getTimestamp() - $now->getTimestamp();
    Cache::put(
        self::TOKEN_KEY,
        $token,
        $cachePeriod
    );
    return $token;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
