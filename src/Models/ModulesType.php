<?php

namespace Suite\Suite\Models;

class ModulesType
{
    use CustomModelTrait;

    const AUTH = "auth";
    const CUSTOMER = "Customer";
    const USER = "User";
    const APPLICATION = "Application";
    const GROUP = "Group";
    const SERVICE_ACL = "ServiceAcl";
    const SERVICE = "Service";
}
