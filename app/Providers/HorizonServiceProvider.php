<?php

namespace App\Providers;

use App\Libraries\Helper\AuthLibrary;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        Horizon::routeSlackNotificationsTo(
            config('haakco.slack_hook_general'),
            '#general'
        );
        // Horizon::night();
    }

    protected function authorization()
    {
        $this->gate();

        Horizon::auth(
            function () {
                return app()->environment('local') ||
                    (new AuthLibrary())->isAllowedToView();
            }
        );
    }

//    /**
//     * Register the Horizon gate.
//     *
//     * This gate determines who can access Horizon in non-local environments.
//     *
//     * @return void
//     */
//    protected function gate()
//    {
//        Gate::define('viewHorizon', function ($user) {
//            return in_array($user->email, [
//                //
//            ]);
//        });
//    }
}
