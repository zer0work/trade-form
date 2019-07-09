<?php


namespace App;


class Config
{
    public $data;
    public function __construct()
    {
        $this->data = [
            'zoho_api' => [
                'client_id' => '1000.NLQCGP7S38OR00208QPBV8I6Z9L55R',
                'client_secret' => '273b091b45a7a05fc85b62cb116d42ca14cf322932',
                'redirect_uri' => 'http://trade-form.test/ZohoAuth/oauth2callback',
            ],
        ];
    }

    public static function get($name)
    {
        $config = new self();
        return $config->data[$name];
    }
}