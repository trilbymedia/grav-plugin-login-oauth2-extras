<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class OktaProvider extends ExtraProvider
{
    protected $name = 'Okta';
    protected $classname = 'Foxworth42\\OAuth2\\Client\\Provider\\Okta';

    public function initProvider(array $options) : void
    {
        $options += [
            'clientId'      => $this->config->get('providers.okta.client_id'),
            'clientSecret'  => $this->config->get('providers.okta.client_secret'),
            'issuer'        => $this->config->get('providers.okta.issuer')
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.okta.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getPreferredUsername(),
            'fullname'   => $user->getName(),
            'email'      => $user->getEmail(),
            'okta'      => [
                'zone_info' => $user->getZoneInfo(),
                'locale' => $user->getLocale()
            ]
        ];

        return $data_user;
    }
}
