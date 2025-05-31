<?php

use Blessing\Filter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Collection;

return function (Dispatcher $events, Filter $filter) {
    $events->listen(
        'SocialiteProviders\Manager\SocialiteWasCalled',
        'SocialiteProviders\Authentik\AuthentikExtendSocialite@handle'
    );

    config(['services.authentik' => [
        'client_id' => env('AUTHENTIK_KEY'),
        'client_secret' => env('AUTHENTIK_SECRET'),
        'redirect' => env('AUTHENTIK_REDIRECT_URI'),
    ]]);

    $filter->add('oauth_providers', function (Collection $providers) {
        $providers->put('authentik', [
            'icon' => 'authentik',
            'displayName' => 'Authentik',
        ]);

        return $providers;
    });
};
