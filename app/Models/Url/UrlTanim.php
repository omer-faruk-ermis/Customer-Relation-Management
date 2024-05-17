<?php

namespace App\Models\Url;

use App\Filters\Url\UrlDefinitionFilter;
use App\Models\AbstractModel;
use App\Models\Authorization\SmsKimlikYetki;
use App\Models\Menu\MenuTanim;
use App\Models\RecorderTrait;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
 *
 * @property-read SmsKimlik      $recorder
 * @property-read SmsKimlik      $members
 * @property-read MenuTanim      $menu
 *
 * @method static Builder|UrlTanim filter(array $filters = [])
 */
class UrlTanim extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.url_tanim';

    public string $recordField = 'kayit_id';

    use RecorderTrait;

    /**
     * @return hasOne
     */
    public function menu(): hasOne
    {
        return $this->hasOne(MenuTanim::class, 'id', 'ust_id');
    }

    /**
     * @return hasManyThrough
     */
    public function members(): hasManyThrough
    {
        return $this->hasManyThrough(
            SmsKimlik::class,
            SmsKimlikYetki::class,
            'url_id',
            'id',
            'id',
            'sms_kimlik'
        );
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
