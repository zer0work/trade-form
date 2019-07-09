<?php


namespace App;


class LeadsCollection
{
    public $leads;

    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    public function getByPhone($phone)
    {
        foreach ($this->leads as $lead) {
            if ($phone == $lead->Phone || $phone == $lead->Mobile ) {
                return $lead;
            }
        }

        return false;
    }
}