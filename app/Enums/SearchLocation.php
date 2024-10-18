<?php

namespace App\Enums;

class SearchLocation extends AbstractEnum
{
    public const ALL = '*';
    public const USER_NAME = 'Kullanıcı Adı';
    public const PHONE = 'Cep Telefonu';
    public const FULL_NAME = 'Adı Soyadı';
    public const SUBSCRIBER_NO = 'Abone Numarası';
    public const CORPORATION_NAME = 'Kurum Adı';
    public const EMAIL = 'Email';
    public const IDENTITY_NO = 'Kimlik Numarası';
    public const TAX_IDENTIFICATION_NO = 'Vergi Numarası';
    public const USER_ID = 'Kullanıcı Id';
    public const SIM_CARD = 'Sim Kart';
}
