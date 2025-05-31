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
        'base_url' => env('AUTHENTIK_BASE_URL'),
        'client_id' => env('AUTHENTIK_CLIENT_ID'),
        'client_secret' => env('AUTHENTIK_CLIENT_SECRET'),
        'redirect' => env('AUTHENTIK_REDIRECT_URI')
    ]]);

    $filter->add('oauth_providers', function (Collection $providers) {
        $providers->put('authentik', [
            'icon' => 'authentik',
            'displayName' => 'Authentik',
        ]);

        return $providers;
    });
};
