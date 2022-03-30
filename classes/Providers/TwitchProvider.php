<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class TwitchProvider extends ExtraProvider
{
    protected $name = 'Twitch';
    protected $classname = 'Vertisan\\OAuth2\\Client\\Provider\\TwitchHelix';

    public function initProvider(array $options): void
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
            'login'      => $user->getLogin(),
            'fullname'   => $user->getDisplayName(),
            'email'      => $user->getEmail(),
            'twitch'      => [
                'avatar_url' => $user->getProfileImageUrl(),
                'bio' => $user->getDescription(),
                'type' => $user->getType()
            ]
        ];

        return $data_user;
    }

}