<?php

namespace Swiftyper;

class Validation extends Places
{
    const OBJECT_NAME = 'validation';

    const INSUFFICIENT = 'insufficient';
    const INVALID = 'invalid';
    const VALID = 'valid';
    const UNSURE = 'unsure';
    const MANY = 'many';

    public $status;

    public function isInsufficient()
    {
        return $this->status === self::INSUFFICIENT;
    }

    public function isInvalid()
    {
        return $this->status === self::INVALID;
    }

    public function isValid()
    {
        return $this->status === self::VALID;
    }

    public function isUnsure()
    {
        return $this->status === self::UNSURE;
    }

    public function isMany()
    {
        return $this->status === self::MANY;
    }
}
