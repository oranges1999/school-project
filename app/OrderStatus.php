<?php

namespace App;

enum OrderStatus: int
{
    case PENDING = 0;
    case CONFIRMED = 1;
    case CANCEL = 2;
    case FINISH = 3;

    public function label()
    {
        return match($this){
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCEL => 'Cancel',
            self::FINISH => 'Finish',
        };
    }
}
