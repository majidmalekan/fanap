<?php

namespace App\Enums;

enum UserRoleEnum :string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function label(): string{
        return match ($this){
            self::ADMIN =>'مدیر',
            self::USER => "کاربر",
        };
    }
}
