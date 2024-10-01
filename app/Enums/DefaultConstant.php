<?php

namespace App\Enums;

class DefaultConstant extends AbstractEnum
{
    const DEFAULT_DATETIME_FORMAT = 'd.m.Y H:i:s';
    const DEFAULT_DATE_FORMAT = 'd.m.Y';
    const DATE_YMD_LINK_FORMAT = 'Y/m/d';
    const SEARCH_LIST_LIMIT = 100;
    const PAGINATE = 25;
    const CACHE_ONE_DAY = 86400;
    const MIN_PASSWORD_LENGTH = 8;
    const ALL_COLUMN = '*';
    const AUTHORIZATION = 324; // id = 324, url => php/main.php from url_tanim
    const HIDE_SIGN = '*';
    const HIDE_DATE_FORMAT = '****-**-**';
    const IDENTITY_NO_LENGTH = 11;
    const TAX_IDENTIFICATION_NO_LENGTH = 10;
    const LOCAL_PHONE_LENGTH = 10;
    const INTERNATIONAL_PHONE_LENGTH = 11;
    const NETGSM_PHONE_PREFIX = 510;
    const PARENT = 0;
    const AUTHORIZATION_GROUP = 'Default Group';
    const CUSTOMER_AGENT_MANAGEMENT = 'Müşteri Temsilci Yönetimi';
    const HAVE_NOT_REASON_WANTED = 0;
}
