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
    // uploaded file
    $image = fopen(public_path('images/avatar.png'),'r');
    // crud
    $suite = new Suite($token);
    $result = $suite->service()->all();
    /**
    $result = $suite->service()->create('sdk service', [
        ServiceAclInfoType::BASE_URL => 'http://localhost',
        ServiceAclInfoType::ACL_ROLES_URL => 'acl',
        ServiceAclInfoType::ACL_ROLES_METHOD => 'get',
    ],$image);
    $result = $suite->service()->show(1);
    $result = $suite->service()->update(1, 'service edited',[
        ServiceAclInfoType::BASE_URL => 'http://localhost',
        ServiceAclInfoType::ACL_ROLES_URL => 'acl',
        ServiceAclInfoType::ACL_ROLES_METHOD => 'get',
    ]);
    $result = $suite->service()->destroy(5);
    $result = $suite->service()->assignApplications(1,[1,2,3]);
    $result = $suite->service()->acl(1);
    **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
