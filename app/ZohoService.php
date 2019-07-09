<?php


namespace App;


class ZohoService
{
    protected $access_token;
    protected $curl;

    public function __construct($accessToken)
    {
        if (empty($accessToken)) {
            throw new \DomainException('Empty accessToken.');
        }

        $this->access_token = $accessToken;

        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            'Authorization:Zoho-oauthtoken '. $this->access_token,
        ));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }


    public function loadLeads()
    {
        curl_setopt($this->curl, CURLOPT_URL, 'https://zohoapis.eu/crm/v2/Leads');
        $server_output = curl_exec($this->curl);

        $result = json_decode($server_output);
        return $result->data;
    }

    public function createLead($firstName, $lastName, $email, $phone)
    {
        curl_setopt($this->curl, CURLOPT_URL, 'https://zohoapis.eu/crm/v2/Leads');

        $params = json_encode(
            [
                "data" => [
                    ["First_Name" => $firstName, 'Last_Name' => $lastName, "Email" => $email, 'Phone' => $phone]
                ],
                "trigger" => [ "approval", "workflow", "blueprint" ]
            ]
        );

        curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'Authorization:Zoho-oauthtoken '. $this->access_token
        ]);

        $result = curl_exec($this->curl);

        return json_decode($result, TRUE);
    }

    public function createContact($firstName, $lastName, $email, $phone)
    {
        curl_setopt($this->curl, CURLOPT_URL, 'https://zohoapis.eu/crm/v2/Contacts');

        $params = json_encode(
            [
                "data" => [
                    [
                        "ownerId" => 205386000000167009,
                        "First_Name" => $firstName,
                        'Last_Name' => $lastName,
                        "Email" => $email,
                        'Phone' => $phone,
                    ]
                ],
                "trigger" => [ "approval", "workflow", "blueprint" ]
            ]
        );

        curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'Authorization:Zoho-oauthtoken '. $this->access_token
        ]);

        $result = curl_exec($this->curl);

        return json_decode($result, TRUE);
    }


    public function createPotentials($potentialName, $contactName, $sum, $comment)
    {
        curl_setopt($this->curl, CURLOPT_URL, 'https://zohoapis.eu/crm/v2/Potentials');

        $params = json_encode(
            [
                "data" => [
                    [
                        'ownerId' => 205386000000167009,
                        'Deal_Name' => $potentialName,
                        'Stage' => 'Оценка пригодности',
                        'Contact Name' => $contactName,
                        'Amount' => $sum,
                        'Description' => $comment
                    ]
                ],
                "trigger" => [ "approval", "workflow", "blueprint" ]
            ]
        );

        curl_setopt($this->curl, CURLOPT_VERBOSE, 1);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'Authorization:Zoho-oauthtoken '. $this->access_token
        ]);

        $result = curl_exec($this->curl);

        return json_decode($result, TRUE);
    }




    public function __destruct()
    {
        curl_close($this->curl);
    }
}