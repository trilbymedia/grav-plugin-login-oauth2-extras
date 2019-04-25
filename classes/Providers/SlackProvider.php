<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Data\Data;
use Grav\Common\Grav;

class SlackProvider extends BaseProvider
{
    protected $name = 'Slack';
    protected $classname = 'AdamPaterson\\OAuth2\\Client\\Provider\\Slack';

    public function __construct()
    {
        parent::__construct();
        $admin = Grav::instance()['oauth2']->isAdmin();
        $this->config = new Data(Grav::instance()['config']->get('plugins.login-oauth2-extras' . ($admin ? '.admin' : '')));
    }

    public function initProvider(array $options)
    {
        $options += [
            'clientId'      => $this->config->get('providers.slack.client_id'),
            'clientSecret'  => $this->config->get('providers.slack.client_secret'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.slack.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data = $user->toArray();

        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getName(),
            'fullname'   => $data['user']['profile']['real_name'],
            'email'      => $user->getEmail(),
            'slack'      => [
                'location'   => $data['user']['tz'],
                'avatar_url' => $data['user']['profile']['image_512'],
            ]
        ];

        return $data_user;
    }
}