<?php

namespace App\Models\Staff;

use App\Filters\StaffGroup\StaffGroupFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PersonelGruplari
 *
 * @package App\Models\Staff
 * @version April 29, 2024, 2:15 pm UTC
 *
 * @property int                       $id
 * @property string                    $grup_adi
 * @property bool                      $durum
 * @property string                    $aciklama
 * @property string                    $kayit_tarihi
 * @property int                       $sms_kimlik
 * @property string                    $mattermost_id
 *
 * @property-read SmsKimlik            $recorder
 * @property-read PersonelGrupEslestir $members
 *
 * @method static Builder|PersonelGruplari filter(array $filters = [])
 */
class PersonelGruplari extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.personel_gruplari';

    public string $recordField = 'sms_kimlik';

    use RecorderTrait;

    protected $fillable = [
        'grup_adi',
        'durum',
        'aciklama',
        'sms_kimlik',
        'kayit_tarihi'
    ];

    /**
     * @return hasMany
     */
    public function members(): hasMany
    {
        return $this->hasMany(PersonelGrupEslestir::class, 'personel_grup_id', 'id')
                    ->with('staff')
                    ->active();
    }

    public function authorizations(): hasMany
    {
        return $this->hasMany(PersonelGrupYetkiEslestir::class, 'personel_grup_id', 'id')
                    ->active();
    }

    /**
     * @param $filters
     *
     * @return StaffGroupFilter
     */
    protected function filter($filters): StaffGroupFilter
    {
        return new StaffGroupFilter($filters);
    }
}
