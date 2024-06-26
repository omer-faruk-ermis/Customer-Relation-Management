<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class Authorization extends AbstractEnum
{
    const SEND_SMS = 1;
    const GUIDE_OPERATIONS = 2;
    const GIVE_CREDIT_PAGE_WILL_NOT_BE_BILLED_OPERATION = 4;
    const GIVE_CREDIT_PAYMENT_PAGE = 5;
    const GIVE_CREDIT_BE_SAVE_ACCOUNTING_OPERATION_FROM_PAYMENT_PAGE = 6;
    const GIVE_CREDIT_CREDIT_TRANSFER_PAGE = 8;
    const BLUE_SCREEN_ACCOUNTING_OPERATIONS_BILL_PREPAYMENT_OPERATION = 9;
    const SMS_MANAGEMENT_CUSTOMER_TRACKING_DEFINE_GIFT_OPERATION = 10;
    const ACCESS_SMS_REPORTS = 11;
    const RECEIVE_DOCUMENTATION = 12;
    const CHANGE_ORGANISATION_INFORMATION = 14;
    const TRANSFER_OPERATIONS = 15;
    const CHANGE_CONTACT_INFORMATION = 16;
    const CHANGE_AUTHORIZED_PERSON = 17;
    const CHANGE_AND_QUEUE_IDENTITY_NO = 18;
    const CHANGE_SUBSCRIBER_TYPE = 19;
    const CHANGE_ADDRESS = 20;
    const CLONE_USER = 21;
    const DELETE_SUBSCRIBER_NO = 22;
    const DELETE_AND_ASSIGNMENT_PILOT_USER = 23;
    const CHANGE_TRUSTWORTHY_CUSTOMER = 24;
    const TRANSPORT_SUBSCRIPTION_ADDRESS = 25;
    const VIRTUAL_POS_AND_3D_POS = 26;
    const TRANSFER_AND_RETURN_PACKAGE = 27;
    const LISTEN_AND_REVOKE_AUDIO_RECORDINGS = 28;
    const COLLECT_CHANGE_CONTACT_INFORMATION = 29;
    const COLLECT_CHANGE_ORGANISATION_INFORMATION = 30;
    const COLLECT_CHANGE_AUTHORIZED_PERSON_INFORMATION = 31;
    const COLLECT_CHANGE_FORWARDING_NO = 32;
    const CHANGE_TWO_STEP_AUTHENTICATION = 33;
    const CHANGE_IYS_MODE = 34;
    const CHANGE_SEND_ACCOUNT_COMMERCIAL_MESSAGE = 35;
    const CONFIRM_AND_REJECT_SENDER_NAME = 36;
    const RECEIVE_CDR_RECORDS = 37;
    const SHOW_CENTRAL_NO = 38;
    const LISTEN_AUDIO_RECORDS = 39;
    const DO_CENTRAL_SETTINGS = 40;
    const PRINT_CDR_AND_AUDIO_RECORDS_AND_ETC = 41;
    const DELETE_CALL_RECORDS_OR_CDR = 42;
    const SHOW_REPORTS = 43;
    const CHANGE_CALLER_ID = 44;
    const CALLER_ID_GROUP_OPERATIONS = 45;
    const CHANGE_AND_FORWARDING_CALL = 46;
    const CHANGE_AND_TRANSFER_CALL = 47;
    const PBX_OPERATIONS = 48;
    const SEARCH_SHORT_CODE = 49;
    const CHANGE_DEFAULT_AREA_CODE = 50;
    const CHANGE_DEFAULT_IP_AND_PORT = 51;
    const MATCH_CUSTOMER_TRACKING_DEALER_GROUP = 52;
    const SHOW_CUSTOMER_TRACKING_DEALER_GROUP = 53;
    const CHANGE_SUBSCRIBER_DEALER = 54;
    const UPDATE_PACKAGE_END_DATE = 55;
    const ACCESS_NETCENTRAL = 56;
    const NETCENTRAL_OPERATION = 57;
    const SHOW_COMPANY_NUMBERS = 58;
    const SHOW_GROUPS = 59;
    const SHOW_DELETED_RECORDS = 60;
    const DUMP_EXCEL_FROM_GUIDE = 61;
    const SHOW_INCOME_SMS = 62;
    const SHOW_STATISTIC = 63;
    const SHOW_PERSONS = 64;
    const DUMP_EXCEL_FROM_SMS = 65;
    const COPY_PACKAGE_FROM_FINANCIAL_OPERATIONS = 66;
    const CHANGE_STATE_PACKAGE_FROM_FINANCIAL_OPERATIONS = 67;
    const DEFINING_AUDIO_CAMPAIGN = 68;
    const DEFINING_STAFF_CAMPAIGN = 69;
}
