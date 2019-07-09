<?php

spl_autoload_register(function($class){
    require_once __DIR__ . str_replace('\\', '/', substr($class, 3)) . '.php';
});

