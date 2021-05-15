<?php

namespace Swiftyper;

class ErrorObject extends SwiftyperObject
{
    public function refreshFrom($values, $opts, $partial = false)
    {
        $values = \array_merge([
            'code' => null,
            'message' => null,
            'param' => null,
            'type' => null,
        ], $values);
        parent::refreshFrom($values, $opts, $partial);
    }
}
