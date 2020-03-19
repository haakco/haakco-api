<?php

namespace App\Providers;

use App\Models\BaseModel\BaseOauthAccessToken;
use App\Models\BaseModel\BaseOauthAuthCode;
use App\Models\BaseModel\BaseOauthClient;
use App\Models\BaseModel\BaseOauthPersonalAccessClient;
use App\Models\BaseModel\BaseOauthRefreshToken;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Route::group(['prefix' => config('haakco.api_path', 'api/v1')], function () {
            Passport::routes();
            Passport::tokensExpireIn(now()->addDays(config('haakco.access_token_lifetime_days', 15)));
            Passport::refreshTokensExpireIn(now()->addDays(config('haakco.refresh_token_lifetime_days', 30)));
            Passport::personalAccessTokensExpireIn(
                now()->addDays(config('haakco.personal_access_token_lifetime_days', 200))
            );
        });
        Passport::enableImplicitGrant();
        Passport::useTokenModel(BaseOauthAccessToken::class);
        Passport::useClientModel(BaseOauthClient::class);
        Passport::useAuthCodeModel(BaseOauthAuthCode::class);
        Passport::usePersonalAccessClientModel(BaseOauthPersonalAccessClient::class);
        Passport::useRefreshTokenModel(BaseOauthRefreshToken::class);
    }
}
