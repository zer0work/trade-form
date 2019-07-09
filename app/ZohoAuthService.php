<?php


namespace App;


class ZohoAuthService
{
    protected $client;

    public function __construct()
    {
        $config = Config::get('zoho_api');
        $this->client = new ZohoClient($config['client_id'], $config['client_secret'], $config['redirect_uri']);
    }

    public function generateAuthorizationUrl()
    {
        return "https://accounts.zoho.eu/oauth/v2/auth".
            "?scope=ZohoCRM.modules.leads.ALL,ZohoCRM.modules.deals.ALL,ZohoCRM.settings.ALL".
            "&client_id={$this->client->client_id}".
            "&response_type=code".
            "&prompt=consent".
            "&access_type=offline".
            "&redirect_uri={$this->client->redirect_uri}";
    }

    public function generateToken($code)
    {
        $clientId = $this->client->client_id;
        $clientSecret = $this->client->client_secret;
        $redirectUri = $this->client->redirect_uri;

        $url = "https://accounts.zoho.eu/oauth/v2/token";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "grant_type=authorization_code".
            "&client_id={$clientId}".
            "&client_secret={$clientSecret}".
            "&redirect_uri={$redirectUri}".
            "&code={$code}"
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $server_output = json_decode($server_output);
        curl_close($ch);

        if (empty($server_output)) {
            throw new \DomainException('Empty response.');
        }

        if(! empty($server_output->error)) {
            throw new \DomainException($server_output->error);
        }

        return $server_output;
    }

    public function refreshToken($refreshToken)
    {
        if (empty($refreshToken)) {
            throw new \DomainException('Empty refreshToken.');
        }

        $clientId = $this->client->client_id;
        $clientSecret = $this->client->client_secret;

        $url = "https://accounts.zoho.eu/oauth/v2/token".
            "?refresh_token={$refreshToken}".
            "&client_id={$clientId}".
            "&client_secret={$clientSecret}".
            "&grant_type=refresh_token";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $server_output = json_decode($server_output);
        curl_close($ch);

        if (empty($server_output)) {
            throw new \DomainException('Empty response.');
        }

        if(! empty($server_output->error)) {
            throw new \DomainException($server_output->error);
        }

        return $server_output;
    }
}