<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class SlackProvider extends BaseProvider
{
    protected $name = 'Slack';
    protected $classname = 'AdamPaterson\\OAuth2\\Client\\Provider\\Slack';

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