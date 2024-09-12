<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Authorization\SmsKimlikWebUserTipYetkiController;
use App\Http\Controllers\API\Authorization\SmsKimlikYetkiController;
use App\Http\Controllers\API\Authorization\YetkiController;
use App\Http\Controllers\API\Call\CagriController;
use App\Http\Controllers\API\Code\CodeController;
use App\Http\Controllers\API\Employee\SmsKimlikController;
use App\Http\Controllers\API\Employee\SmsKimlikSipController;
use App\Http\Controllers\API\Employee\SmsKimlikUnitController;
use App\Http\Controllers\API\Enum\EnumController;
use App\Http\Controllers\API\Log\LogController;
use App\Http\Controllers\API\Menu\DetayMenuController;
use App\Http\Controllers\API\Menu\DetayMenuUserController;
use App\Http\Controllers\API\Menu\MenuTanimController;
use App\Http\Controllers\API\Module\ModuleController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapController;
use App\Http\Controllers\API\QuestionAnswer\SoruCevapKategoriController;
use App\Http\Controllers\API\Reason\SebeplerController;
use App\Http\Controllers\API\Sms\SmsController;
use App\Http\Controllers\API\Staff\PersonelGrupController;
use App\Http\Controllers\API\Staff\PersonelGrupEslestirController;
use App\Http\Controllers\API\Staff\PersonelGrupYetkiEslestirController;
use App\Http\Controllers\API\Subject\KonuBilgiController;
use App\Http\Controllers\API\Subject\KonuBilgiKullanimYeriController;
use App\Http\Controllers\API\Subscriber\AboneKutukYetkiController;
use App\Http\Controllers\API\Token\DocSignatureController;
use App\Http\Controllers\API\Url\UrlTanimController;
use App\Http\Controllers\API\VoiceUser\VoiceUserController;
use App\Http\Controllers\API\WebPortal\WebPortalYetkiController;
use App\Http\Controllers\API\WebPortal\WebPortalYetkiIzinController;
use App\Http\Controllers\API\WebUser\WebUserController;
use App\Models\Operator\OperatorTanimlari;
use App\Models\Sebep\SebepIstenecekler;

return [

    AuthController::class => [
        'LOGIN'              => 'Oturum bilgileriniz doğru, yönlendiriliyorsunuz.',
        'LOGIN_VERIFICATION' => 'Uygulamalar yüklendi.',
        'FORGOT_PASSWORD'    => 'Bilgileriniz doğru, yönlendiriliyorsunuz.',
        'NEW_PASSWORD'       => 'Yeni şifreniz oluşturuldu.',
        'CHANGE_PASSWORD'    => 'Şifreniz değiştirildi.',
        'LOGOUT'             => 'Şifreniz değiştirildi.'
    ],

    EnumController::class => [
        'INDEX' => 'Enum Listesi'
    ],

    SmsKimlikWebUserTipYetkiController::class => [
        'CREATE'  => 'Personel ve Kullanıcı Tipi eşleşmesi oluşturuldu.',
        'DESTROY' => 'Personel ve Kullanıcı Tipi eşleşmesi silindi.',
        'BULK'    => 'Personel ve Kullanıcı Tipi ile toplu işlem gerçekleştirildi.'
    ],

    SmsKimlikYetkiController::class => [
        'CREATE'  => 'Personel yetkisi oluşturuldu.',
        'DESTROY' => 'Personel yetkisi silindi.',
        'BULK'    => 'Personel yetkisi ile toplu işlem gerçekleştirildi.'
    ],

    YetkiController::class => [
        'COPY' => 'Personel yetkisi kopyalandı.',
    ],

    CagriController::class => [
        'INDEX' => 'Çağrı listesi',
    ],

    CodeController::class => [
        'CREATE' => 'Kod görseli oluşturuldu.',
    ],

    SmsKimlikController::class => [
        'INDEX'           => 'Personel listesi',
        'BASIC'           => 'Sadeleştirilmiş personel listesi',
        'LOG'             => 'Personelin log listesi',
        'SHOW'            => 'Personel detayları',
        'CREATE'          => 'Personel oluşturuldu.',
        'UPDATE'          => 'Personel güncellendi.',
        'PASSWORD_UPDATE' => 'Personel şifresi güncellendi.',
        'DESTROY'         => 'Personel silindi.',
    ],

    SmsKimlikSipController::class => [
        'INDEX'   => 'Personel dahili numara listesi',
        'CREATE'  => 'Personel dahili numara kaydı oluşturuldu.',
        'DESTROY' => 'Personel dahili numara kaydı silindi.',
    ],

    SmsKimlikUnitController::class => [
        'INDEX' => 'Personel birimleri listesi',
    ],

    LogController::class => [
        'EMPLOYEE' => [
            'INDEX' => 'Personel logları listesi',
        ],
        'REASON'   => [
            'UPDATE' => 'Sebep logları güncellendi.',
        ],
    ],

    DetayMenuController::class => [
        'MENU' => [
            'INDEX' => 'Menü listesi',
        ],
        'PAGE' => [
            'INDEX' => 'Sayfa listesi',
        ],
    ],

    DetayMenuUserController::class => [
        'CREATE'  => 'Personel yetkisi oluşturuldu.',
        'DESTROY' => 'Personel yetkisi silindi.',
        'BULK'    => 'Personel yetkisi ile toplu işlem gerçekleştirildi.'
    ],

    MenuTanimController::class => [
        'INDEX'   => 'Menü listesi',
        'CREATE'  => 'Menü oluşturuldu.',
        'UPDATE'  => 'Menü güncellendi',
        'DESTROY' => 'Menü silindi.',
    ],

    ModuleController::class => [
        'INDEX'   => 'Modül listesi',
        'CREATE'  => 'Modül oluşturuldu.',
        'UPDATE'  => 'Modül güncellendi',
        'DESTROY' => 'Modül silindi.',
    ],

    OperatorTanimlari::class => [
        'INDEX' => 'Operatör Tanimlar listesi',
    ],

    SoruCevapController::class => [
        'INDEX'   => 'Soru-Cevap listesi',
        'CREATE'  => 'Soru-Cevap oluşturuldu.',
        'UPDATE'  => 'Soru-Cevap güncellendi',
        'DESTROY' => 'Soru-Cevap silindi.',
    ],

    SoruCevapKategoriController::class => [
        'INDEX'   => 'Soru-Cevap Kategori listesi',
        'CREATE'  => 'Soru-Cevap Kategori oluşturuldu.',
        'UPDATE'  => 'Soru-Cevap Kategori güncellendi',
        'DESTROY' => 'Soru-Cevap Kategori silindi.',
    ],

    SebeplerController::class => [
        'INDEX' => 'Sebepler listesi',
    ],

    SebepIstenecekler::class => [
        'INDEX' => 'Sebep İstenecekler listesi',
    ],

    SmsController::class => [
        'SEND'              => 'Sms gönderildi.',
        'CODE_VERIFICATION' => 'Sms onaylandı.',
    ],

    PersonelGrupController::class => [
        'INDEX'   => 'Personel Grup listesi',
        'SHOW'    => 'Personel Grubu detayları',
        'CREATE'  => 'Personel Grubu oluşturuldu.',
        'UPDATE'  => 'Personel Grubu güncellendi',
        'DESTROY' => 'Personel Grubu silindi.',
    ],

    PersonelGrupEslestirController::class => [
        'CREATE'  => 'Personel Grubu ile personel eşleştirildi.',
        'DESTROY' => 'Personel Grubu ile personel eşleşmesi silindi.',
        'BULK'    => 'Personel Grubu ve personel eşleşmesi için toplu işlem gerçekleştirildi.'
    ],

    PersonelGrupYetkiEslestirController::class => [
        'CREATE'  => 'Personel Grubu ile yetki eşleştirildi.',
        'DESTROY' => 'Personel Grubu ile yetki eşleşmesi silindi.',
        'BULK'    => 'Personel Grubu ve yetki eşleşmesi için toplu işlem gerçekleştirildi.'
    ],

    KonuBilgiController::class => [
        'INDEX'   => 'Konu listesi',
        'CREATE'  => 'Konu bilgi oluşturuldu.',
        'UPDATE'  => 'Konu bilgi güncellendi.',
        'DESTROY' => 'Konu bilgi silindi.',
    ],

    KonuBilgiKullanimYeriController::class => [
        'INDEX' => 'Konu kullanım yeri listesi',
    ],

    AboneKutukYetkiController::class => [
        'MENU' => [
            'INDEX' => 'Abone Kütük Menü listesi',
        ],
        'PAGE' => [
            'INDEX' => 'Abone Kütük Sayfa listesi',
        ],
    ],

    DocSignatureController::class => [
        'INDEX' => 'Token bilgileri',
    ],

    UrlTanimController::class => [
        'INDEX'   => 'Sayfa listesi',
        'CREATE'  => 'Sayfa oluşturuldu.',
        'UPDATE'  => 'Sayfa güncellendi',
        'DESTROY' => 'Sayfa silindi.',
    ],

    VoiceUserController::class => [
        'STORE'          => 'Kullanıcının ses kaydı oluşturuldu.',
        'PATH'           => 'Kullanıcının ses kayıt yolu',
        'LAST_PAIR_USER' => 'Son eşleşmiş kullanıcılar listesi',
        'DESTROY'        => 'Kullanıcının ses kaydı silindi.',
    ],

    WebPortalYetkiController::class => [
        'MENU' => [
            'INDEX' => 'Yetkilendirme Menü listesi',
        ],
        'PAGE' => [
            'INDEX' => 'Yetkilendirme Sayfa listesi',
        ],
    ],

    WebPortalYetkiIzinController::class => [
        'CREATE'  => 'Personel Grubu ile işlem yetkisi eşleştirildi.',
        'DESTROY' => 'Personel Grubu ile işlem yetki eşleşmesi kaldırıldı.',
        'BULK'    => 'Personel Grubu ile işlem yetki eşleşmesi için toplu işlem gerçekleştirildi.'
    ],

    WebUserController::class => [
        'INDEX' => 'Kullanıcılar listesi',
        'TYPE'  => 'Kullanıcı tipler listesi',
        'SHOW'  => 'Kullanıcı detayları'
    ],
];
