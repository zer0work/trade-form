<?php

namespace App\Controllers;

use App\ZohoAuthService;

class ZohoAuthController
{
    protected $service;

    public function __construct()
    {
        $this->service = new ZohoAuthService();
    }

    public function oauth2callback()
    {
        try {
            $data = $this->service->generateToken($_GET['code']);
        } catch (\DomainException $e) {
            echo $e->getMessage();
            die;
        }

        session_start();
        $_SESSION['access_token'] = $data->access_token;
        if (! empty($data->refresh_token)) {
            $_SESSION['refresh_token'] = $data->refresh_token;
        }
        $_SESSION['token_expired_at'] = time() + $data->expires_in_sec;

        header('Location: http://trade-form.test');
        exit();
    }

    public function refreshToken()
    {
        session_start();
        try {
            $data = $this->service->refreshToken($_SESSION['refresh_token']);
        } catch (\DomainException $e) {
            echo $e->getMessage();
            die;
        }

        $_SESSION['access_token'] = $data->access_token;
        if (! empty($data->refresh_token)) {
            $_SESSION['refresh_token'] = $data->refresh_token;
        }
        $_SESSION['token_expired_at'] = time() + $data->expires_in_sec;

        header('Location: http://trade-form.test');
        exit();
    }
}