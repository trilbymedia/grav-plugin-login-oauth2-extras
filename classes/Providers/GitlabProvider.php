<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class GitlabProvider extends ExtraProvider
{
    protected $name = 'Gitlab';
    protected $classname = 'Omines\\OAuth2\\Client\\Provider\\Gitlab';

    public function initProvider(array $options): void
    {
        $domain = $this->config->get('providers.gitlab.domain', false);

        $options += [
            'clientId'      => $this->config->get('providers.gitlab.client_id'),
            'clientSecret'  => $this->config->get('providers.gitlab.client_secret'),
        ];

        if ($domain) {
            $options += ['domain' => $domain];
        }

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.gitlab.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data = $user->toArray();

        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUsername(),
            'fullname'   => $user->getName(),
            'email'      => $user->getEmail(),
            'gitlab'     => [
                'domain'     => $user->getDomain(),
                'location'   => $data['location'],
                'web_url'    => $user->getProfileUrl(),
                'avatar_url' => $user->getAvatarUrl(),
                'active'     => $user->isActive(),
                'external'   => $user->isExternal(),
                'admin'      => $user->isAdmin()
            ]
        ];

        return $data_user;
    }
}