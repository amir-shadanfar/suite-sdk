<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

try {
    // dont need to get token, send clientId & clientSecret
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::CLIENT_CREDENTIALS,[
        'base_url' => 'http://suite.rockads.mobylonia.com',
        'api_version' => 'v1',
        'client_id' => '1',
        'client_secret' => 'qdFMCWXAGN4VFHqPJuMGMXTOmJwJpQo8IKRvcAzb',
    ]);

    return $suiteAuth->register(
        "customer_name",
        "customer_workspace",
        [1],
        "customer@example.com",
        "customer"
    );
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
