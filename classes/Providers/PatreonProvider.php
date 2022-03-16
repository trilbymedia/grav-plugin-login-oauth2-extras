<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class PatreonProvider extends ExtraProvider
{
    protected $name = 'Patreon';
    protected $classname = 'Gravure\\Patreon\\Oauth\\Provider\\Patreon';

    public function initProvider(array $options): void
    {
        $options += [
            'clientId'      => $this->config->get('providers.patreon.client_id'),
            'clientSecret'  => $this->config->get('providers.patreon.client_secret'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.patreon.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data = $user->toArray();

        $data_user = [
            'id'         => $user->getId(),
            'login'      => $data['email'],
            'fullname'   => $data['full_name'],
            'email'      => $data['email'],
            'patreon'      => [
                'avatar_url' => $user->getAvatar(),
                'url' => $data['url'],
            ]
        ];

        return $data_user;
    }
}