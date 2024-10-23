<?php

use App\Enums\DefaultConstant;
use App\Exceptions\Auth\AgainPasswordException;
use App\Exceptions\Auth\AuthInformationException;
use App\Exceptions\Auth\InvalidPasswordFormatException;
use App\Exceptions\Auth\LoginAlreadyException;
use App\Exceptions\Auth\NotLoginException;
use App\Exceptions\Auth\OldPasswordException;
use App\Exceptions\Auth\PasswordLengthException;
use App\Exceptions\Auth\SessionTimeOutException;
use App\Exceptions\Authorization\AuthorizationTypeNotFoundException;
use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\Authorization\EmployeeWebUserTypeAuthorizationAlreadyHaveException;
use App\Exceptions\Authorization\EmployeeWebUserTypeAuthorizationNotFoundException;
use App\Exceptions\Call\CallNotFoundException;
use App\Exceptions\Call\VoiceUserAlreadyHaveException;
use App\Exceptions\Code\InvalidSecurityCodeException;
use App\Exceptions\Code\SecurityCodeIncorrectException;
use App\Exceptions\Code\SecurityCodeMaxAttemptException;
use App\Exceptions\Code\SecurityCodeUseTimeException;
use App\Exceptions\DetailMenu\DetailMenuUserAlreadyHaveException;
use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Exceptions\Employee\EmployeeAuthorizationAlreadyHaveException;
use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Exceptions\Employee\EmployeeSipNotFoundException;
use App\Exceptions\Employee\HaveAlreadyEmployeeException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\InvalidEnumException;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\Log\LogReasonRecordNotFoundException;
use App\Exceptions\Log\LogRecordNotFoundException;
use App\Exceptions\Log\MeetingOperatorLogNotFoundException;
use App\Exceptions\Meeting\MeetingMainNotFoundException;
use App\Exceptions\Menu\MenuAlreadyHaveException;
use App\Exceptions\Menu\MenuNotFoundException;
use App\Exceptions\Module\ModuleAlreadyHaveException;
use App\Exceptions\Module\ModuleNotFoundException;
use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Exceptions\QuestionAnswer\QuestionAnswerNotFoundException;
use App\Exceptions\Reason\ReasonNotFoundException;
use App\Exceptions\RelationHaveException;
use App\Exceptions\Sms\OtpMessageNotSendException;
use App\Exceptions\Sms\SmsIdentityNotVerifiedException;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchAlreadyHaveException;
use App\Exceptions\Staff\StaffGroupAuthorizationMatchNotFoundException;
use App\Exceptions\Staff\StaffGroupMatchAlreadyHaveException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Exceptions\Staff\StaffGroupNotFoundException;
use App\Exceptions\Subject\SubjectInformationNotFoundException;
use App\Exceptions\Subscriber\CustomerPriorityNotFoundException;
use App\Exceptions\Subscriber\SpecialCustomerAlreadyHaveException;
use App\Exceptions\Subscriber\SpecialCustomerNotFoundException;
use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\Token\InvalidTokenFormatException;
use App\Exceptions\Url\HaveAlreadyUrlDefinitionException;
use App\Exceptions\Url\UrlDefinitionNotFoundException;
use App\Exceptions\Voice\VoiceUserNotFoundException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionAlreadyHaveException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Exceptions\WebUser\WebUserNotFoundException;

return [

    AgainPasswordException::class                               => 'Tekrar girdiğiniz şifre bilgisi hatalıdır.',
    AuthInformationException::class                             => 'Mail veya şifre bilgisi hatalı!',
    InvalidPasswordFormatException::class                       => 'Geçersiz Şifre Formatı!',
    NotLoginException::class                                    => 'Henüz oturum açılmadı!',
    LoginAlreadyException::class                                => 'Oturum açılması zaten onaylandı!',
    OldPasswordException::class                                 => 'Eski şifreniz ile girilen eski şifre bilgisi uyuşmamaktadır.',
    PasswordLengthException::class                              => "Şifre minimum " . DefaultConstant::MIN_PASSWORD_LENGTH . "karakter uzunluğunda olmalıdır.",
    SessionTimeOutException::class                              => 'Oturum süresi doldu!',
    AuthorizationTypeNotFoundException::class                   => 'Yetki tipi bulunamadı!',
    EmployeeAuthorizationNotFoundException::class               => 'Personel yetki kaydı bulunamadı!',
    EmployeeWebUserTypeAuthorizationAlreadyHaveException::class => 'Personelin kullanıcı tipi ile ilişkili yetki kaydı zaten mevcut!',
    EmployeeWebUserTypeAuthorizationNotFoundException::class    => 'Personelin kullanıcı tipi ile ilişkili yetki kaydı bulunamadı!',
    CallNotFoundException::class                                => 'Arama kaydı bulunamadı!',
    InvalidSecurityCodeException::class                         => 'Geçersiz Güvenlik Kodu!',
    SecurityCodeIncorrectException::class                       => '',
    SecurityCodeMaxAttemptException::class                      => 'Kodu 3 kez hatalı girdiğiniz için geçersiz kılındı! Lütfen kodu tekrar gönderin.',
    SecurityCodeUseTimeException::class                         => 'Kodu 3 dakikadan uzun süredir girmediğiniz için kodunuz geçersizdir! Lütfen kodu tekrar gönderin.',
    DetailMenuUserAlreadyHaveException::class                   => 'Personel yetki kaydı zaten mevcut!',
    DetailMenuUserNotFoundException::class                      => 'Personel yetki kaydı bulunamadı!',
    EmployeeAuthorizationAlreadyHaveException::class            => 'Personel yetki kaydı zaten mevcut!',
    RelationHaveException::class                                => 'Alt ilişki kaydı mevcut! İşlem yapılamaz.',
    InvalidEnumException::class                                 => 'Enum Tipi Uygun Değildir!',
    InvalidParameterException::class                            => 'Parametre Uygun Değildir!',
    ForbiddenException::class                                   => 'Forbidden!',
    WebUserNotFoundException::class                             => 'Müşteri kaydı bulunamadı!',
    WebPortalAuthorizationPermissionNotFoundException::class    => 'Web Portal izni bulunamadı!',
    WebPortalAuthorizationPermissionAlreadyHaveException::class => 'Web Portal izin kaydı zaten mevcut!',
    VoiceUserNotFoundException::class                           => 'Ses ile eşleştirilmiş bir kullanıcı kaydı bulunamadı!',
    UrlDefinitionNotFoundException::class                       => 'Alt menü kaydı bulunamadı!',
    HaveAlreadyUrlDefinitionException::class                    => 'Girilen alt menü kaydı zaten mevcut!',
    InvalidTokenFormatException::class                          => 'Geçersiz Token Formatı!',
    InvalidTokenException::class                                => 'Geçersiz Token!',
    StaffGroupNotFoundException::class                          => 'Personel grup kaydı bulunamadı!',
    StaffGroupMatchNotFoundException::class                     => 'Yetki Grubu ile personel eşleşme kaydı bulunamadı!',
    StaffGroupMatchAlreadyHaveException::class                  => 'Yetki Grubu ile personel eşleşme kaydı zaten mevcut!',
    StaffGroupAuthorizationMatchNotFoundException::class        => 'Yetki Grubu ile yetki eşleşme kaydı bulunamadı!',
    StaffGroupAuthorizationMatchAlreadyHaveException::class     => 'Yetki Grubu ile yetki eşleşme kaydı zaten mevcut!',
    SmsIdentityNotVerifiedException::class                      => 'Sms Kimlik Doğrulanamadı!',
    OtpMessageNotSendException::class                           => 'OTP message gönderilemedi!',
    QuestionAnswerNotFoundException::class                      => 'Soru-Cevap bulunamadı!',
    QuestionAnswerCategoryNotFoundException::class              => 'Kategori bulunamadı!',
    ModuleNotFoundException::class                              => 'Modül kaydı bulunamadı!',
    ModuleAlreadyHaveException::class                           => 'Modül kaydı zaten mevcut!',
    MenuNotFoundException::class                                => 'Menü kaydı bulunamadı!',
    MenuAlreadyHaveException::class                             => 'Menü kaydı zaten mevcut!',
    MeetingMainNotFoundException::class                         => 'Görüşme kaydı bulunamadı!',
    MeetingOperatorLogNotFoundException::class                  => 'Operator log kaydı bulunamadı!',
    LogRecordNotFoundException::class                           => 'Log kaydı bulunamadı!',
    LogReasonRecordNotFoundException::class                     => 'Sebep log kaydı bulunamadı!',
    HaveAlreadyEmployeeException::class                         => 'Girilen mail ile kayıtlı personel kaydı zaten mevcut!',
    EmployeeSipNotFoundException::class                         => 'Personel dahili numarası bulunamadı!',
    EmployeeNotFoundException::class                            => 'Personel kaydı bulunamadı!',
    SubjectInformationNotFoundException::class                  => 'Konu bilgi kaydı bulunamadı!',
    ReasonNotFoundException::class                              => 'Sebep kaydı bulunamadı!',
    SpecialCustomerNotFoundException::class                     => 'Özel Müşteri Temsilci kaydı bulunamadı!',
    CustomerPriorityNotFoundException::class                    => 'Özel Müşteri Temsilci veya Vip Müşteri kaydı bulunamadı!',
    SpecialCustomerAlreadyHaveException::class                  => 'Özel Müşteri Temsilci kaydı zaten mevcut!',
    VoiceUserAlreadyHaveException::class                        => 'Ses eşleştirme kaydı zaten mevcut!',

];
