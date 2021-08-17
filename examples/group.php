<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Constants\ServiceAclInfoType;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\Suite;

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
    $result = $suite->group()->all();
    $result = $suite->group()->create('group name');
    $result = $suite->group()->show(1);
    $result = $suite->group()->update(3, "group name updated");
    $result = $suite->group()->destroy(3);
    $result = $suite->group()->assignApplication(1,[1,2,3]);
    **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
