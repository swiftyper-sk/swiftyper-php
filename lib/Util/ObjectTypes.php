<?php

namespace Swiftyper\Util;

class ObjectTypes
{
    /**
     * @var array Mapping from object types to resource classes
     */
    const mapping = [
        \Swiftyper\Place::OBJECT_NAME => \Swiftyper\Place::class,
            \Swiftyper\Address::OBJECT_NAME => \Swiftyper\Address::class,
            \Swiftyper\Street::OBJECT_NAME => \Swiftyper\Street::class,
            \Swiftyper\Municipality::OBJECT_NAME => \Swiftyper\Municipality::class,
            \Swiftyper\PostalCode::OBJECT_NAME => \Swiftyper\PostalCode::class,
            \Swiftyper\Validation::OBJECT_NAME => \Swiftyper\Validation::class,

        \Swiftyper\Business::OBJECT_NAME => \Swiftyper\Business::class,
    ];
}
