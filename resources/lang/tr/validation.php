<?php

return [
    'required'       => ':attribute alanı gereklidir.',
    'string'         => ':attribute bir metin olmalıdır.',
    'max'            => [
        'string'  => ':attribute en fazla :max karakter uzunluğunda olmalıdır.',
        'numeric' => ':attribute en fazla :max olmalıdır.',
        'file'    => ':attribute en fazla :max kilobyte boyutunda olmalıdır.',
        'array'   => ':attribute en fazla :max öğeye sahip olmalıdır.',
    ],
    'min'            => [
        'string'  => ':attribute en az :min karakter uzunluğunda olmalıdır.',
        'numeric' => ':attribute en az :min olmalıdır.',
        'file'    => ':attribute en az :min kilobyte boyutunda olmalıdır.',
        'array'   => ':attribute en az :min öğeye sahip olmalıdır.',
    ],
    'email'          => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'unique'         => ':attribute daha önce alınmış.',
    'exists'         => 'Seçilen :attribute geçersiz.',
    'url'            => ':attribute geçerli bir URL olmalıdır.',
    'confirmed'      => ':attribute onayı eşleşmiyor.',
    'date'           => ':attribute geçerli bir tarih olmalıdır.',
    'boolean'        => ':attribute alanı true veya false olmalıdır.',
    'numeric'        => ':attribute bir sayı olmalıdır.',
    'integer'        => ':attribute bir tam sayı olmalıdır.',
    'digits_between' => ':attribute :min ile :max basamak arasında olmalıdır.',
    'digits' => ':attribute :digits basamaklı olmalıdır.',
    'image'          => ':attribute bir resim olmalıdır (jpg, jpeg, png, bmp, gif veya svg).',
    'file'           => ':attribute bir dosya olmalıdır.',
    'array'          => ':attribute bir dizi olmalıdır.',
    'between'        => [
        'string'  => ':attribute :min ile :max karakter arasında olmalıdır.',
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'file'    => ':attribute :min ile :max kilobyte arasında olmalıdır.',
        'array'   => ':attribute :min ile :max öğe arasında olmalıdır.',
    ],
    'date_format'    => ':attribute :format formatında olmalıdır.',
    'different'      => ':attribute ve :other farklı olmalıdır.',
    'in'             => 'Seçilen :attribute geçersiz.',
    'not_in'         => 'Seçilen :attribute geçersiz.',
    'regex'          => ':attribute biçimi geçersiz.',
    'json'           => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'timezone'       => ':attribute geçerli bir zaman dilimi olmalıdır.',
    'active_url'     => ':attribute geçerli bir URL olmalıdır.',
    'nullable'       => ':attribute alanı boş bırakılabilir.',
    'ip'             => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'           => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'           => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'encrpyt_fields' => ':attribute alanı üç veya daha fazla \'*\' karakteri içermemelidir.',

    'attributes' => [
        'name'                                   => 'İsim',
        'email'                                  => 'E-posta',
        'password'                               => 'Şifre',
        'login_permission'                       => 'Giriş izni',
        'mobile_phone'                           => 'Mobil telefon',
        'old_password'                           => 'Eski şifre',
        'new_password'                           => 'Yeni şifre',
        'new_password_again'                     => 'Tekrar yeni şifre',
        'security_code'                          => 'Güvenlik kodu',
        'security_code_path'                     => 'Güvenlik kod url',
        'code'                                   => 'Kod',
        'bulk_authorizations'                    => 'Toplu yetkilendirmeler',
        'bulk_authorizations.*.employee_id'      => 'Personel ID\'si',
        'bulk_authorizations.*.authorization_id' => 'Yetkilendirme ID\'si',
        'bulk_authorizations.*.is_authorized'    => 'Yetkilendirilme durumu',
        'bulk_authorizations.*.web_user_type'    => 'Yetkilendirme Kullanıcı tipi',
        'bulk_authorizations.*.operator_code'    => 'Yetkilendirme operatör kodu',
        'bulk_authorizations.*.staff_group_id'   => 'Yetkilendirme Personel grubu ID',
        'bulk_authorizations.*.staff_id'         => 'Yetkilendirme Personel ID',
        'bulk_authorizations.*.type'             => 'Yetkilendirme tipi',
        'employee_id'                            => 'Personel ID',
        'receiver_id'                            => 'Alıcı ID',
        'authorization_id'                       => 'Yetki ID',
        'web_user_type'                          => 'Kullanıcı tipi',
        'web_user'                               => 'Kullanıcı',
        'operator_code'                          => 'Operatör kodu',
        'full_name'                              => 'Tam isim',
        'unit'                                   => 'Birim',
        'unit_id'                                => 'Birim ID',
        'sip'                                    => 'Dahili',
        'currency_limit'                         => 'Para limit',
        'home_phone'                             => 'Ev telefonu',
        'max_date'                               => 'Bitiş tarihi',
        'min_date'                               => 'Başlangıç tarihi',
        'log_subject'                            => 'Konu logu',
        'page'                                   => 'Sayfa',
        'agent'                                  => 'Müşteri Temsilcisi',
        'description'                            => 'Açıklama',
        'reason'                                 => 'Sebep',
        'empty_reason'                           => 'Sebep dahil mi?',
        'empty_description'                      => 'Açıklama dahil mi?',
        'not_send_message'                       => 'Mesaj gönderilmesin',
        'enum_type'                              => 'Enum tip',
        'process_person'                         => 'İşlem yapan personel',
        'path'                                   => 'Url',
        'icon'                                   => 'Icon',
        'color'                                  => 'Renk',
        'module_id'                              => 'Modül ID',
        'panel'                                  => 'Panel',
        'category_id'                            => 'Kategori ID',
        'question'                               => 'Soru',
        'answer'                                 => 'Cevap',
        'question_keywords'                      => 'Soru anahtar kelimeleri',
        'answer_keywords'                        => 'Cevap anahtar kelimeleri',
        'category_name'                          => 'Kategori adı',
        'type'                                   => 'Tip',
        'log_id'                                 => 'Log ID',
        'reason_id'                              => 'Reason ID',
        'staff_group_id'                         => 'Personel Group ID',
        'staff_id'                               => 'Personel ID',
        'state'                                  => 'Durum',
        'use_place_id'                           => 'Kullanım alanı ID',
        'parent_id'                              => 'Üst\Ebeveyn ID',
        'user_type_ids'                          => 'Kullanıcı tip ID\'leri',
        'use_state'                              => 'Kullanım durumu',
        'url'                                    => 'Url',
        'menu_id'                                => 'Menü ID',
        'background_id'                          => 'Arkaplan ID',
        'call_phone'                             => 'Çağrı Telefonu',
        'voice_record'                           => 'Ses Kaydı',
        'call_start_date'                        => 'Çağrı başlangıç tarihi',
        'call_id'                                => 'Çağrı ID',
        'user_id'                                => 'Kullanıcı ID',
        'location'                               => 'Kullanıcı alanı',
        'user_type'                              => 'Kullanıcı tipi',
        'agreement_state'                        => 'Sözleşme durumu',
    ],
];
