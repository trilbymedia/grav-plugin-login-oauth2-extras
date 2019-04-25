<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Data\Data;
use Grav\Common\Grav;

class DiscordProvider extends BaseProvider
{
    protected $name = 'Discord';
    protected $classname = 'Wohali\\OAuth2\\Client\\Provider\\Discord';

    public function __construct()
    {
        parent::__construct();
        $admin = Grav::instance()['oauth2']->isAdmin();
        $this->config = new Data(Grav::instance()['config']->get('plugins.login-oauth2-extras' . ($admin ? '.admin' : '')));
    }

    public function initProvider(array $options)
    {
        $options += [
            'clientId'      => $this->config->get('providers.discord.client_id'),
            'clientSecret'  => $this->config->get('providers.discord.client_secret'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.discord.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data = $user->toArray();

        $avatar_url = "https://cdn.discordapp.com/avatars/{$data['id']}/{$data['avatar']}.jpg";

        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUsername(),
            'fullname'   => $user->getUsername(),
            'email'      => $user->getEmail(),
            'discord'      => [
                'discriminator' => $data['discriminator'],
                'verified' => $data['verified'],
                'locale' => $data['locale'],
                'mfa_enabled' => $data['mfa_enabled'],
                'avatar_url' => $avatar_url,
            ]
        ];

        return $data_user;
    }
}