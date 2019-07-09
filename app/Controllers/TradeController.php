<?php

namespace App\Controllers;

use App\LeadsCollection;
use App\View;
use App\ZohoAuthService;
use App\ZohoService;

class TradeController
{
    protected $auth_service;
    protected $zoho_service;

    public function __construct()
    {
        session_start();
        $this->auth_service = new ZohoAuthService();

        $this->OAuth();

        $this->zoho_service = new ZohoService($_SESSION['access_token']);
    }

    public function index()
    {
        View::display('form');
    }

    public function store()
    {
        try {
            $leads = $this->zoho_service->loadLeads();
        } catch (\DomainException $e) {
            echo $e->getMessage();
            die;
        }

        $lead = (new LeadsCollection($leads))->getByPhone($_POST['phone']);

        if (empty($lead)) {
            $this->zoho_service->createLead($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone']);
        } else {
            $potentialName = $_POST['first_name']. $_POST['last_name'];
            $contactName = $_POST['first_name'];
            $sum = $_POST['sum'];
            $comment = $_POST['comment'];
            $this->zoho_service->createContact($contactName, $_POST['last_name'], $_POST['email'], $_POST['phone']);
            $this->zoho_service->createPotentials($potentialName, $contactName, $sum, $comment);
        }

        header('Location: /');
        exit();
    }

    private function OAuth()
    {
        if (empty($_SESSION['access_token']) || empty($_SESSION['refresh_token']) || empty($_SESSION['token_expired_at'])) {
            header('Location: '. (new ZohoAuthService())->generateAuthorizationUrl());
            exit();
        }

        if (time() > $_SESSION['token_expired_at']) {
            header('Location: http://trade-form.test/ZohoAuth/refreshToken');
            exit();
        }
    }
}