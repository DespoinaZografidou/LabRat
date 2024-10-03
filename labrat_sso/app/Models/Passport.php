<?php

namespace App\Models;
use Laravel\Passport\Client;

class Passport extends Client {
    public function skipAuthorization()
    {
       //false: All the clients should stop for authorazation
       return false;
    }
}