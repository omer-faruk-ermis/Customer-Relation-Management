<?php

namespace App\Filters\Call;


class UserPhone
{
    public function apply($query, $value): void
    {
        $query->havingRaw('(CASE WHEN ses_user.kul_tur = 0 THEN musteri.cep_tel ELSE webuser.ceptel END) LIKE ?', ['%' . $value . '%']);
    }
}
