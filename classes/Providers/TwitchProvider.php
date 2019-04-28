<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class TwitchProvider extends ExtraProvider
{
    protected $name = 'Twitch';
    protected $classname = 'Depotwarehouse\\OAuth2\\Client\\Twitch\\Provider\\Twitch';

    public function initProvider(array $options)
    {
        $options += [
            'clientId'      => $this->config->get('providers.twitch.client_id'),
            'clientSecret'  => $this->config->get('providers.twitch.client_secret'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.twitch.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUsername(),
            'fullname'   => $user->getDisplayName(),
            'email'      => $user->getEmail(),
            'twitch'      => [
                'avatar_url' => $user->getLogo(),
                'bio' => $user->getBio(),
                'type' => $user->getType()
            ]
        ];

        return $data_user;
    }
}