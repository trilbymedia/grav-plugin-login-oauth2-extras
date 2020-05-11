<?php

namespace Gravure\Patreon\Oauth\Provider;

use Gravure\Patreon\Oauth\Resources\Factory;
use Gravure\Patreon\Oauth\Resources\Patron;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Patreon extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';

    /**
     * @var string
     */
    protected $apiBaseUrl = 'https://www.patreon.com/api/oauth2/';
    /**
     * @var string
     */
    protected $oauthBaseUrl = 'https://www.patreon.com/oauth2/';

    /**
     * @var array
     */
    protected $scopes = [
        'users', 'pledges-to-me', 'my-campaign'
    ];

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->oauthBaseUrl . 'authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->apiBaseUrl . 'token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiBaseUrl . 'api/current_user';
    }

    protected function getAuthorizationHeaders($token = null)
    {
        return $token ? [
            'Authorization' => 'Bearer ' . $token
        ] : [];
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['users'];
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        $error = null;

        if (isset($data['error'])) {
            $error['detail'] = $data['error'];
            $error['code'] = 401;
        }
        if (isset($data['errors']) && count($data['errors'])) {
            $error = array_shift($data['errors']);
        }

        if ($error) {
            throw new IdentityProviderException(
                $error['detail'],
                $error['code'],
                $response
            );
        }
    }

    /**
     * @return string
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface|Patron
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return Factory::create((array) $response);
    }
}
