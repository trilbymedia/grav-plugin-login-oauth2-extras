<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Data\Data;
use Grav\Common\Grav;

class ExtraProvider extends BaseProvider
{
    public function __construct()
    {
        parent::__construct();
        $admin = Grav::instance()['oauth2']->isAdmin();
        $this->config = new Data(Grav::instance()['config']->get('plugins.login-oauth2-extras' . ($admin ? '.admin' : '')));
    }

    public function getAuthorizationUrl()
    {

    }

    public function getUserData($user)
    {

    }
}