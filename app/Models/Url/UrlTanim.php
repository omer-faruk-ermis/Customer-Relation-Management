<?php

namespace App\Models\Url;

use App\Filters\Url\UrlDefinitionFilter;
use App\Models\AbstractModel;
use App\Models\Authorization\SmsKimlikYetki;
use App\Models\Menu\MenuTanim;
use App\Models\RecorderTrait;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class UrlTanim
 *
 * @package App\Models\Url
 * @version April 26, 2024, 0:05 pm UTC
 *
 * @property int                 $id
 * @property string              $adi
 * @property string              $url
 * @property string              $ust_id
 * @property bool                $durum
 * @property int                 $arkaplan_id
 * @property int                 $tab_id
 * @property int                 $kayit_id
 * @property string              $kayit_ip
 * @property string              $kayit_tarih
 *
 * @property-read SmsKimlik      $recorder
 * @property-read SmsKimlikYetki $authorizations
 * @property-read MenuTanim      $menu
 *
 * @method static Builder|UrlTanim filter(array $filters = [])
 */
class UrlTanim extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.url_tanim';

    use RecorderTrait;

    protected $fillable = [
        'adi',
        'url',
        'ust_id',
        'durum',
        'arkaplan_id',
        'tab_id',
        'kayit_id',
        'kayit_ip',
        'kayit_tarih'
    ];

    /**
     * @return hasMany
     */
    public function authorizations(): hasMany
    {
        return $this->hasMany(SmsKimlikYetki::class, 'url_id', 'id')
                    ->with('members');
    }

    /**
     * @return hasOne
     */
    public function menu(): hasOne
    {
        return $this->hasOne(MenuTanim::class, 'id', 'ust_id');
    }

    /**
     * @param $filters
     *
     * @return UrlDefinitionFilter
     */
    protected function filter($filters): UrlDefinitionFilter
    {
        return new UrlDefinitionFilter($filters);
    }

}
