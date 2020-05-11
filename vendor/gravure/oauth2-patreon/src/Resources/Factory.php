<?php

namespace Gravure\Patreon\Oauth\Resources;

use Gravure\Patreon\Oauth\Exceptions\InvalidResourceException;

class Factory
{
    /**
     * @var array
     */
    protected static $mapping = [
        'user' => Patron::class,
        'pledge' => Pledge::class,
    ];

    /**
     * @param array $payload
     * @return Resource
     */
    public static function create(array $payload)
    {
        $data = array_key_exists('data', $payload) ? $payload['data'] : $payload;
        $type = $data['type'];
        $included = array_key_exists('included', $payload) ? $payload['included'] : [];
        $relationships = array_key_exists('relationships', $payload) ? $payload['included'] : [];

        if (false === array_key_exists($type, static::$mapping)) {
            throw new InvalidResourceException("Resource type $type not mapped.");
        }

        $class = static::$mapping[$type];

        /** @var Resource $resource */
        $resource = new $class;
        $resource->id = $data['id'];
        $resource->type = $type;
        $resource->attributes = $data['attributes'];

        foreach ($relationships as $type => $relationship) {
            if (!is_array($relationship['data'])) {
                $relationship['data'] = (array) $relationship['data'];
            }

            $resource->relationships[$type] = [];

            foreach ($relationship['data'] as $relation) {
                if (! isset($relation['type'], $relation['id'])) {
                    continue;
                }

                array_push(
                    $resource->relationships[$type],
                    static::retrieveIncluded($relation['type'], $relation['id'], $included)
                );
            }

        }

        return $resource;
    }

    /**
     * @param $type
     * @param $id
     * @param array $included
     * @return null|void
     */
    protected static function retrieveIncluded($type, $id, array $included = [])
    {
        foreach ($included as $resource) {
            if ($resource['type'] === $type && $resource['id'] === $id) {
                return static::create($resource);
            }
        }

        return null;
    }
}
