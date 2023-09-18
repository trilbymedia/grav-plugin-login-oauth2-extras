<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class WordpressProvider extends ExtraProvider
{
    protected $name = 'Wordpress';
    protected $classname = 'Krombox\\OAuth2\\Client\\Provider\\WordPress';

    public function initProvider(array $options) : void
    {
        $options += [
            'clientId'      => $this->config->get('providers.wordpress.client_id'),
            'clientSecret'  => $this->config->get('providers.wordpress.client_secret'),
            'domain'        => $this->config->get('providers.wordpress.domain'),
            'redirectUri'   => $this->getCallbackUri()
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.wordpress.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUsername(),
            'email'      => $user->getEmail(),
            'username'   => $user->toArray()['name'],
        ];

        return $data_user;
    }
}
