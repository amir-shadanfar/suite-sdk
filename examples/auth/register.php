<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

try {
    // dont need to get token, send clientId & clientSecret
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::CLIENT_CREDENTIALS);

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
