<?php

namespace App\DTO;

class ClientInfoDTO
{
    public $ip;
    public $userAgent;

    public function __construct($ip, $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }
}
