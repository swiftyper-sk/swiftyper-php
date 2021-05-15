<?php

spl_autoload_register(function ($class_name) {
    include __DIR__ . '/lib/'. str_replace("Swiftyper\\", "", $class_name) . '.php';
});
