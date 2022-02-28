<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use Grav\Common\Grav;
use GuzzleHttp\Promise;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class AzureProvider extends ExtraProvider
{
    protected $name = 'Azure';
    protected $classname = 'TheNetworg\\OAuth2\\Client\\Provider\\Azure';

    public function initProvider(array $options): void
    {
        $options += [
            'clientId'      => $this->config->get('providers.azure.client_id'),
            'clientSecret'  => $this->config->get('providers.azure.client_secret'),
            'tenant'        => $this->config->get('providers.azure.tenant'),
            // Get access tokens for the Microsoft Graph API instead of the old Azure AD Graph.
            'urlAPI'        => 'https://graph.microsoft.com',
            'resource'      => 'https://graph.microsoft.com',
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
        $name = $user->claim('name');
        $data_user = [
            'id'         => $user->getId(),
            'login'      => $user->getUpn(),
            'fullname'   => $name,
            'email'      => $user->claim('email') ?: $user->getUpn(),
            'azure'      => [
                // The avatar can be set by using avatar_url or avatar.
                // Technically we're not setting a url because pictures from Azure are not public, so this contains a
                // data url with a base64 encoded image.
                'avatar' => $this->getAvatar($name),
                'issuer' => $user->claim('iss'),
                'tenant' => $user->getTenantId(),
            ]
        ];

        $getGroups = $this->config->get('providers.azure.options.get_groups');
        if ($getGroups)
        {
            $data_user['groups'] = $this->getUserGroups($name);
        }

        return $data_user;
    }

    public function getAvatar($name)
    {
        $avatarMaxSize = $this->config->get('providers.azure.options.avatar_max_size');
        // This should already be validated to be at least 48, because that's the lowest available resolution, but just
        // to be sure.
        if ($avatarMaxSize < 48)
        {
            $avatarMaxSize = 48;
        }

        // First get the meta information for all the available pictures, there are versions from 48x48 to 648x648,
        // depending on the size uploaded by the user.
        // Use the beta endpoint to get the profile picture as the v1.0 endpoint only returns the picture if the user
        // has a mailbox. See https://docs.microsoft.com/en-us/graph/known-issues#users
        $photoMetaUrl = 'https://graph.microsoft.com/beta/me/photos/';
        try
        {
            $photoMetaList = $this->provider->get($photoMetaUrl, $this->token);
        }
        catch (IdentityProviderException $e)
        {
            // User seems to have no picture.
            Grav::instance()['log']->info('AzureProvider: failed to get photo for user \'' . $name .
                '\'. Exception message: ' . $e->getMessage());
            return null;
        }

        // Limit picture size by width or height, depending on which is larger.
        $comparisonProperty = $photoMetaList[0]['height'] > $photoMetaList[0]['width'] ? 'height' : 'width';

        // Filter pictures by maximum size that was configured.
        $photoMetaList = array_filter(
            $photoMetaList,
            function ($photoMeta) use ($comparisonProperty, $avatarMaxSize)
            {
                return $photoMeta[$comparisonProperty] <= $avatarMaxSize;
            }
        );

        // Get the metadata for the largest remaining picture.
        $photoMeta = array_reduce(
            $photoMetaList,
            function($carry, $item) use ($comparisonProperty){
                return $carry[$comparisonProperty] < $item[$comparisonProperty] ? $item : $carry;
            },
            [$comparisonProperty => -PHP_INT_MAX]
        );

        // Get the actual picture.
        $photoUrl = $photoMetaUrl . $photoMeta['id'] . '/$value';
        try
        {
            $photo = $this->provider->get($photoUrl, $this->token);
        }
        catch (IdentityProviderException $e)
        {
            // Getting the picture failed even though getting the meta succeeded.
            Grav::instance()['log']->error('AzureProvider: failed to get photo for user \'' . $name .
                '\'. Exception message: ' . $e->getMessage());
            return null;
        }

        // Use a data url with a base64 encoded image since we need to provide a url for the avatar.
        return 'data:' . $photoMeta['@odata.mediaContentType'] . ';base64,' . base64_encode($photo);
    }

    public function getUserGroups($name)
    {
        // Get the ids to the groups a user is member of, including transitive memberships.
        $graphUrl = 'https://graph.microsoft.com/v1.0/';
        $memberGroupsUri = $graphUrl . 'me/getMemberGroups';
        $body = [ 'securityEnabledOnly' => true ];
        try
        {
            $groupIds = $this->provider->post($memberGroupsUri, $body, $this->token);
        }
        catch (IdentityProviderException $e)
        {
            // User might not be able to join any groups (e.g. personal Microsoft account).
            Grav::instance()['log']->info('AzureProvider: cannot get groups for user \'' . $name .
                '\'. Exception message: ' . $e->getMessage());
            return array();
        }

        // Get the whole group objects for each id in parallel by abusing Guzzle promises.
        // Implementing this kind of parallelism in the lower level oauth2-azure and oauth2-client libraries would be
        // better, but that might take a while, so doing it this way is faster for now.

        // Start the requests to Microsoft Graph.
        $promises = array();
        foreach ($groupIds as $groupId)
        {
            $groupUrl = $graphUrl . 'groups/' . $groupId;
            $promises[$groupId] = Promise\task(
                function () use ($groupUrl)
                {
                    return $this->provider->get($groupUrl, $this->token);
                }
            );
        }

        // Wait until all the requests complete.
        $results = Promise\settle($promises)->wait();

        // Get the actual groups or error messages from each request.
        $groups = array();
        foreach ($results as $groupId => $result)
        {
            if($result['state'] === Promise\PromiseInterface::FULFILLED)
            {
                $groups[$groupId] = $result['value'];
            }
            else
            {
                $message = $result['reason']->getMessage();
                Grav::instance()['log']->error(
                    'AzureProvider: failed to get name for group \'' . $groupId . '\'. Exception message: ' . $message);
            }
        }

        // Extract the names from the group objects
        return array_column($groups, 'displayName');
    }
}
