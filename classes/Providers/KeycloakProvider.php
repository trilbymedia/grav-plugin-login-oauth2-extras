<?php

namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Grav;
use Stevenmaguire\OAuth2\Client\Provider\KeycloakResourceOwner;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;

class KeycloakProvider extends ExtraProvider
{
    /** @var string */
    protected $name = 'Keycloak';
    /** @var string */
    protected $classname = Keycloak::class;

    public function initProvider(array $options): void
    {
        $options += [
            'realm'                 => $this->config->get('providers.keycloak.realm'),
            'clientId'              => $this->config->get('providers.keycloak.client_id'),
            'clientSecret'          => $this->config->get('providers.keycloak.client_secret'),
            'authServerUrl'         => $this->config->get('providers.keycloak.authserver_url'),
            'encryptionAlgorithm'   => $this->config->get('providers.keycloak.encryption_algorithm'),
            'encryptionKey'         => $this->config->get('providers.keycloak.encryption_key'),
	];

        parent::initProvider($options);
    }

    /**
     * @return string
     */
    public function getAuthorizationUrl(): string
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.keycloak.options.scope');
        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user): array
    {
        $data = $user->toArray();
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $data[$this->config->get('providers.keycloak.userdata_login')],
            'fullname'   => $data[$this->config->get('providers.keycloak.userdata_fullname')],
            'email'      => $data[$this->config->get('providers.keycloak.userdata_email')],
            'keycloak'   => $data,
        ];

        return $data_user;
    }
}
