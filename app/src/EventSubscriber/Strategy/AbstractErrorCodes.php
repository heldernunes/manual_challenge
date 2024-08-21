<?php

namespace App\EventSubscriber\Strategy;

abstract class AbstractErrorCodes
{
    public const ROUTE_NOT_FOUND = 100;

    public const INVALID_PARAM_CODE = 200;

    public const REMOTE_PROVIDER_ERROR = 300;

    public const API_EXCEPTION_CODE = 400;

    public const GENERAL_EXCEPTION_CODE = 900;
}
