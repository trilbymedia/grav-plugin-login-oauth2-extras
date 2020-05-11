<?php

namespace Gravure\Patreon\Oauth\Resources;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * @property string $about
 * @property string $created
 * @property int $discord_id
 * @property string $email
 * @property string $facebook
 * @property string $facebook_id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property int $gender
 * @property bool $has_password
 * @property string $thumb_url
 * @property string $image_url
 * @property bool $is_deleted
 * @property bool $is_email_verified
 * @property bool $is_nuked
 * @property bool $is_suspended
 * @property array $social_connections
 * @property string $twitter
 * @property string $url
 * @property string $vanity
 * @property string $youtube
 */
class Patron extends Resource implements ResourceOwnerInterface
{
    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->attributes['vanity'];
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->attributes['image_url'];
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge([
            'id' => $this->id,
            'type' => $this->type,
        ], $this->attributes);
    }
}
