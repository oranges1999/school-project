<?php

namespace App;

enum Role: int
{
    case ADMIN = 1;
    case SHIPPER = 2;

    public function label()
    {
        return match($this){
            self::ADMIN => 'Admin',
            self::SHIPPER => 'Shipper'
        };
    }
}
