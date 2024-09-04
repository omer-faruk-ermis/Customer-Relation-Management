<?php

namespace App\Enums;

class MeetingLog extends AbstractEnum
{
    const FIRST_RECORD = 'ilk_kayit';
    const DELETED_RECORD = 'kayit_silindi';
    const WAS_DELETED_RECORD = 'kayit_silinmis';

    const DELETED_MEETING_RECORD = 'gorusme_kaydi_silinmis';
    const MADE_FROM_EDIT_PAGE_ON_MEETING_RECORD = 'görüşme kaydı düzenleme sayfasından yapılmış';

    const RECORD_COMPLETION_PROCESS_FROM_BLUE_SCREEN = 'mavi_ekrandan_kaydi_tamamlama_islemi';
    const RETURN_RECORD_ON_BLUE_SCREEN = 'maviekran_geri_donus_kaydi';
    const DELETED_MEETING_RECORD_FROM_BLUE_SCREEN = 'maviekrandan_gorusme_kaydi_silinmis';

    const DELETED_SUB_MEETING_RECORD = 'alt gorusme kaydi silinmis';
    const FROM_RETURN_USERS_PAGE = 'geri dönülecek kullanıcılar sayfasından';

    const DELETED_MEETING_RECORD_FROM_SMS_MANAGEMENT_OR_MEETING_RECORD_PAGE = 'smsyonetim / görüşme kaydı sayfasından kayıt silinmis';
    const SMS_MANAGEMENT_OR_RETURN_USERS_PAGE = 'smsyönetim / geri dönülecek kullanıcılar sayfası';

    const ENTERED_TO_CONTROLLER_PAGE_FOR_ONE = '1 için controller sayfasına girildi.';
    const ENTERED_TO_CONTROLLER_PAGE_FOR_TWO = '2 için controller sayfasına girildi.';
    const ENTERED_TO_CONTROLLER_PAGE_FOR_THREE = '3 için controller sayfasına girildi.';
    const ENTERED_TO_CONTROLLER_PAGE_FOR_FOUR = '4 için controller sayfasına girildi.';
    const ENTERED_TO_CONTROLLER_PAGE_FOR_SIX = '6 için controller sayfasına girildi.';
}
