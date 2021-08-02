<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\Suite;

include_once '../../../../../vendor/autoload.php';

try {
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'username' => 'user@example.com',
        'password' => '123!@#asd',
        'workspace' => 'workspace_one',
    ]);
    // token can be cached as mention in example/auth/token.php
    $token = $auth->getToken();
    // customer crud
    $suite = new Suite($token);
    $result = $suite->customer()->all();
    /**
     * $result = $suite->customer()->create('customerName', 'customerWorkSpace', [1]);
     * $result = $suite->customer()->show(3);
     * $result = $suite->customer()->update(3, 'customerName', 'customerWorkSpace', [1,2]);
     * $result = $suite->customer()->destroy(3);
     * $result = $suite->customer()->syncServices(4,[1,2,3]);
     */
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
