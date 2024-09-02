<?php

namespace App\Models\WebPortal;

use App\Enums\Authorization\AuthorizationUserType;
use App\Filters\WebPortal\WebPortalYetkiFilter;
use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * Class WebPortalYetki
 *
 * @package App\Models\WebPortal
 * @version April 26, 2024, 0:05 pm UTC
 *
 * @property int    $id
 * @property string $aciklama
 * @property bool   $durum
 * @property Carbon $tarih
 * @property string $tanim
 * @property string $yetki_detay
 * @property int    $menu_id
 * @property int    $tip
 *
 * @method static Builder|WebPortalYetki filter(array $filters = [])
 */
class WebPortalYetki extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.webportal_yetki';

    /**
     * @return hasManyThrough
     */
    public function members(): hasManyThrough
    {
        return $this->hasManyThrough(
            SmsKimlik::class,
            WebPortalYetkiIzin::class,
            'yetki_id',
            'id',
            'id',
            'userid'
        )->where('usermi', '=', AuthorizationUserType::AGENT);
    }

    /**
     * @param $filters
     *
     * @return WebPortalYetkiFilter
     */
    protected function filter($filters): WebPortalYetkiFilter
    {
        return new WebPortalYetkiFilter($filters);
    }
}
