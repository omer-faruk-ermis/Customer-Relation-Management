<?php

namespace App\Enums;

class Model extends AbstractEnum
{
    const LOG = 'SmsKimlikLog';
    const QUESTION_ANSWER = 'SoruCevap';
    const EMPLOYEE = 'SmsKimlik';
    const CALL = 'Cagri';
    const STAFF_GROUP = 'PersonelGruplari';
    const URL_DEFINITION = 'UrlTanim';
    const REASON = 'Sebepler';
    const CUSTOMER_PRIORITY_MATCH = 'VipOzelMusteriEslestir';
    const WEB_USER = 'WebUser';
    const BLOCKED_IDENTITY_NO = 'EngellenenKimlikNo';
    const BLOCKED_PHONE = 'EngellenenTelNo';
    const BLOCKED_EMAIL = 'EngellenenMail';
    const BLOCKED_TAX_IDENTIFICATION_NO = 'EngellenenVergiNo';
}
