<?php

namespace App\Providers;

use App\Services\AgileTeknik\Auth\AuthService;
use App\Services\AgileTeknik\Auth\IAuthService;
use App\Services\API\APIResponse;
use App\Services\API\IAPIResponse;
use App\Services\Crypt\CryptService;
use App\Services\Crypt\ICryptService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        IAPIResponse::class => APIResponse::class,
        ICryptService::class => CryptService::class,
        IAuthService::class => AuthService::class,
    ];
}
