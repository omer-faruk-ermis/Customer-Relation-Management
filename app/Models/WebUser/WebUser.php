<?php

namespace App\Models\WebUser;

use App\Filters\WebUser\WebUserFilter;
use App\Models\AbstractModel;

/**
 * Class WebUser
 *
 * @package App\Models
 * @property string $name
 * @property string $ad
 * @property string $soyad
 * @property string $ceptel
 * @property string $full_name
 * @property string $kullanici_tipi
 * @property string $tckimlik
 * @property string $abone_no
 * @property string $abonetip
 * @property string $kurumadi
 */
class WebUser extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.webuser';

    /**
     * The attributes that should be appended to the model's array representation.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->ad . ' ' . $this->soyad;
    }

    /**
     * @param $filters
     * @return WebUserFilter
     */
    protected function filter($filters): WebUserFilter
    {
        return new WebUserFilter($filters);
    }
}
