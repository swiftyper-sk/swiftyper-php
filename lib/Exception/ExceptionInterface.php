<?php

namespace Swiftyper\Exception;

if (\interface_exists(\Throwable::class, false)) {
    /**
     * The base interface for all Swiftyper exceptions.
     */
    interface ExceptionInterface extends \Throwable
    {
    }
} else {
    /**
     * The base interface for all Swiftyper exceptions.
     */
    // phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses
    interface ExceptionInterface
    {
    }
    // phpcs:enable
}
