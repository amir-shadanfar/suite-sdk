<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Constants\ServiceAclInfoType;
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
    // service crud
    $suite = new Suite($token);
    $result = $suite->application()->all();
    /**
    $result = $suite->application()->create('application1','android','123123');
    $result = $suite->application()->show(1);
    $result = $suite->application()->update(3, "group name updated");
    $result = $suite->application()->destroy(3);
    **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
