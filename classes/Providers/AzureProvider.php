<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class AzureProvider extends ExtraProvider
{
    protected $name = 'Azure';
    protected $classname = 'TheNetworg\\OAuth2\\Client\\Provider\\Azure';

    public function initProvider(array $options)
    {
        $options += [
            'clientId'      => $this->config->get('providers.azure.client_id'),
            'clientSecret'  => $this->config->get('providers.azure.client_secret'),
            'tenant'        => $this->config->get('providers.azure.tenant'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.azure.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUpn(),
            'fullname'   => $user->claim('name'),
            'email'      => $user->claim('email') ?: $user->getUpn(),
            'azure'      => [
                'issuer' => $user->claim('iss'),
                'tenant' => $user->getTenantId(),
            ]
        ];

        return $data_user;
    }
}