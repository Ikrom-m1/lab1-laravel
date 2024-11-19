<?php

namespace App\DTO;

class UserDTO
{
    public $name;
    public $email;

    public function __construct($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }
}
