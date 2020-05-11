<?php

namespace Gravure\Patreon\Oauth\Resources;

class Resource
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $relationships = [];

    /**
     * {@inheritdoc}
     */
    public function __get($name)
    {
        return array_key_exists($name, $this->attributes) ?
            $this->attributes[$name] :
            null;
    }
}
