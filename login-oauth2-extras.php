<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class LoginOAuth2ExtrasPlugin
 * @package Grav\Plugin
 */
class LoginOAuth2ExtrasPlugin extends Plugin
{
    protected $admin = false;

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => [
                ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ],
            'onTwigLoader'              => ['onTwigLoader', 0],
            'onTwigSiteVariables'       => ['onTwigSiteVariables', 0],
            'onTwigTemplatePaths'       => ['onTwigTemplatePaths', 0],
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        if ($this->isAdmin() && $this->grav['config']->get('plugins.login-oauth2.admin.enabled')) {
            $this->admin = true;
        }

        // Don't proceed if we are in the admin plugin
        if ( $this->isAdmin() && !$this->admin) {
            return;
        }

        $this->addEnabledProviders();
    }

    /**
     * [onPluginsInitialized:100000] Composer autoload.
     *
     * @return ClassLoader
     */
    public function autoload()
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    public function onTwigLoader()
    {
        $media_paths = $this->grav['locator']->findResources('plugins://login-oauth2-extras/media');
        foreach(array_reverse($media_paths) as $images_path) {
            $this->grav['twig']->addPath($images_path, 'oauth2-media');
        }
    }

    /**
     * [onTwigTemplatePaths] Add twig paths to plugin templates.
     */
    public function onTwigTemplatePaths()
    {
        $twig = $this->grav['twig'];
        $twig->twig_paths[] = __DIR__ . '/templates';
    }

    public function onTwigSiteVariables()
    {
        // add CSS for frontend if required
        if ((!$this->isAdmin() && $this->config->get('plugins.login-oauth2-extras.built_in_css')) ||
            ($this->admin && $this->config->get('plugins.login-oauth2-extras.admin.built_in_css'))) {
            $this->grav['assets']->add('plugin://login-oauth2-extras/css/login-oauth2-extras.css');
        }
    }

    protected function addEnabledProviders()
    {
        if (isset($this->grav['oauth2'])) {
            $oauth2 = $this->grav['oauth2'];

            if ($this->admin) {
                $providers = $this->config->get('plugins.login-oauth2-extras.admin.providers', []);
            } else {
                $providers = $this->config->get('plugins.login-oauth2-extras.providers', []);
            }

            foreach ($providers as $provider => $options) {
                if ($options['enabled']) {
                    $oauth2->addProvider($provider, $options);
                }
            }
        }
    }
}
