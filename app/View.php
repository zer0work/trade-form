<?php


namespace App;


class View
{
    public static function display($name)
    {
        $template = __DIR__ . '/../templates/'. $name. '.php';

        include $template;

    }
}