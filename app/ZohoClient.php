<?php


namespace App;


class ZohoClient
{
    public $client_id;
    public $client_secret;
    public $redirect_uri;

    public function __construct($client_id, $client_secret, $redirect_uri)
    {
        $this->client_id     = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri  = $redirect_uri;
    }
}