<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class SmsManagement extends AbstractEnum
{
    // Main Menu
    const USER_OPERATIONS = 1;
    const MANAGEMENT_OPERATIONS = 2;
    const SPECIAL_OPERATIONS = 3;
    const LIST_OPERATIONS = 4;
    const AUDIO_OPERATIONS = 5;
    const DEALER_OPERATIONS = 6;
    const STATISTICS = 7;
    const ETHERNET_OPERATIONS = 8;
    const ORDER_OPERATIONS = 9;
    const FINANCIAL_OPERATIONS = 14;
    const SUBSCRIBER_OPERATIONS = 15;
    const PRICING = 16;

    // Sub Menu

    const E_CASHIER = 5;
    const APPROVE_SENDER = 7;
    const USES_CREDIT_CARD = 25;
    const APP_MANAGEMENT = 27;
    const SENDER_NAMES = 37;
    const SMS_GRAPHIC_REPORTS = 38;
    const READY_MESSAGES = 45;
    const PAYMENT_NOTIFICATIONS = 46;
    const BLOCK_NUMBER = 47;
    const APP_EMPLOYEE = 49;
    const MATCH_AUDIO_RECORD = 57;
    const RETURN_USERS = 62;
    const STATUS_TABLE = 65;
    const LIST_CALL = 70;
    const DEFINE_REASON = 72;
    const MANAGEMENT_ANNOUNCEMENT = 76;
    const LIST_GUARD = 104;
    const SUBSCRIBER_ORGANISATION_TYPE_ADDITIONAL_DOCUMENT = 109;
    const LIST_CUSTOMER_REQUEST = 119;
    const LIST_CREDIT = 121;
    const LIST_INVOICE = 143;
    const INCOME_SMS_STATISTIC = 154;
    const LIST_CAMPAIGN_EARNING = 155;
    const CREATE_USER_GROUPS = 156;
    const LIST_SMS_COST_STATISTIC = 160;
    const MATCH_NOT_WITH_DEALER_CODE = 161;
    const LIST_INSTALLMENT_PAYMENT = 175;
    const UPDATE_EXCHANGE_INFORMATION = 178;
    const HAVE_MISSING_DOCUMENT = 181;
    const LIST_TRANSPORT_NUMBER = 182;
    const INCOME_SMS = 195;
    const CHANGE_USER_INFORMATION = 196;
    const BLOCK_IPS = 199;
    const PEER_STATUS = 201;
    const MANAGEMENT_DEALER_MENU = 203;
    const DEALER_MENU = 204;
    const LIST_BANK_INVOICE_COLLECTION = 209;
    const LIST_FORWARDING_MEMBER = 223;
    const SUBSCRIBER_NUMBERS = 225;
    const DEALER_MANAGEMENT_ANNOUNCEMENT = 225;
    const LIST_INVOICE_REQUEST = 230;
    const BLACK_LIST_ACTIVATION = 235;
    const TEMPLATE_DEALER_CALCULATION = 237;
    const PACKAGE_SUBSCRIPTION = 241;
    const USER_SERVICE_STATISTIC = 246;
    const BLOCK_ATB_KAMAILIO_IPS = 247;
    const ACCOUNTING_MOVEMENTS = 253;
    const LIST_COMMITMENT_TRACKING = 254;
    const ACCOUNT_MOVEMENTS = 255;
    const CAMPAIGN_COST_STATISTIC = 257;
    const HEADING_WITH_SUBSCRIPTION_DETECTION = 259;
    const LIST_INVOICE_LIMIT = 260;
    const GIVE_CREDIT = 262;
    const MANAGEMENT_READY_QUESTION_ANSWERS = 264;
    const CREDIT_CARD_POS_OPERATIONS = 269;
    const CALL_RECORDS_STATISTIC = 270;
    const QUEUE_ARCHIVE_REPORT = 272;
    const CALLED_NUMBER_STATISTIC = 273;
    const AVAILABLE_NUMBERS = 277;
    const LIST_WIRE_TRANSFER_EFT_ORDER = 279;
    const SAVED_CREDIT_CARD_OPERATIONS = 280;
    const FORWARDING_CUSTOMER_AUTHORIZATION = 281;
    const LIST_RECONCILIATION = 282;
    const LIST_APPROVE_DOCUMENT = 284;
    const LIST_USER_NETCENTRAL = 285;
    const LIST_DEVICE_NETCONTROL = 286;
    const LIST_INTERCONNECTION_OPERATOR = 287;
    const LIST_ORDER_DEVICE = 288;
    const LIST_PRODUCT = 289;
    const LIST_STOCK_DEVICE = 290;
    const LIST_SUPPLIER_DEVICE = 291;
    const LIST_RECEIVE_DEVICE = 292;
    const LIST_SCANNING_MESSAGE = 293;
    const ANALYSIS_NUMBER = 294;
    const APPROVE_SHORT_MESSAGE_4609 = 295;
    const TRANSPORT_NUMBER_STATISTIC = 296;
    const SUBSCRIBER_DOCUMENT_NAMES = 297;
    const LIST_INCOME_MESSAGE_4609 = 298;
    const LIST_DEALER = 299;
    const LIST_SUBSCRIBER_DISSOLUTION = 300;
    const TODAY_WILL_CLOSED_CENTRALS = 301;
    const GRAPHIC_REPORTS_MEMBER = 302;
    const LIST_DEBTORS = 303;
    const MANAGEMENT_DEBTORS_FORWARDING_GROUP = 304;
    const CALL_CENTER_BREAK_STATISTIC = 305;
    const LIST_APPROVE_LINE_USER = 308;
    const LETTER_OPERATIONS = 310;
    const LIST_SALE_PACKAGE = 313;
    const LIST_NEW_DEVICE_NETCONTROL = 314;
    const SHORT_URL_OPERATIONS = 315;
    const INTEGRATIONS = 316;
    const SPECIAL_CUSTOMER_AGENT = 319;
    const DEFINE_VIP_CUSTOMER = 320;
    const FORWARDING_CUSTOMER = 322;
    const AUTHORIZED_GROUPS = 323;
    const NEW_ANNOUNCEMENTS = 324;
    const GENERAL_STATISTIC = 326;
    const LIST_BUSINESS_PARTNER = 327;
    const DO_DECRISE_FROM_INVOICE = 328;
    const LIST_PROMOTION = 329;
    const LIST_RECIPE_PACKAGE = 330;
    const NUMBER_OF_800_OPERATIONS = 332;
    const AUDIO_CALL_REPORT = 334;
    const SMS_FILTER = 340;
    const AUTHORIZED_GROUPS_GROUP = 341;
    const DEFINE_PRICE = 342;
    const LIST_SUB_USER = 349;
    const TERMINATION_SUPPORT_REQUESTS = 350;
    const DATA_TRAFFIC_REPORT = 351;
    const NUMBER_STATISTIC = 352;
    const INTERNATIONAL_SMS_LEVELS = 354;
    const SUBSCRIBER_NOTIFICATION_FORMAT = 355;
    const LIST_IP_ENTRY = 356;
    const PDKS_CLOUD_SERVICES = 365;
    const NETASSISTANT_CLOUD_SERVICES = 366;
    const NETIYS_CLOUD_SERVICES = 367;
    const NUMBER_OF_800_CLOUD_SERVICES = 368;
    const CALL_RECORD_CLOUD_SERVICES = 369;
    const NETIOT_CLOUD_SERVICES = 370;
    const AUDIO_RECORD_ANALYSIS_CLOUD_SERVICES = 371;
    const TEMPLATE_MAIL = 374;
    const QUEUE_TT_ADDRESS = 375;
    const QUEUE_BBK = 376;
    const QUEUE_PSTN_XDSL_BBK = 377;
    const BACKUP_SIM_CARD = 378;
    const ETHERNET_PURCHASE_SALE = 379;
    const PENDING_APPROVE_ORDERS = 380;
    const LIST_PAYMENT = 381;
    const DEFINE_SUBJECT = 383;
    const LIST_INDIVIDUAL_ACTIVATION_TRACKING = 384;
}