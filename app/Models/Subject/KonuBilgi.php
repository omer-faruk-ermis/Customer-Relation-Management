<?php

namespace App\Models\Subject;

use App\Enums\Status;
use App\Filters\Subject\SubjectInformationFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class KonuBilgi
 *
 * @package App\Models\Subject
 * @version June 25, 2024, 9:21 pm UTC
 *
 * @property int               $id
 * @property string            $ad
 * @property int               $hit
 * @property int               $durum
 * @property int               $kayit_id
 * @property string            $kayit_ip
 * @property string            $kayit_tar
 * @property int               $tip
 * @property string            $aciklama
 * @property int               $ust_id
 * @property int               $kullanim_yeri
 * @property int               $kullanim_durum
 * @property string            $konuno
 * @property string            $konupath
 * @property string            $kullanici_tipi
 *
 * @property-read KonuBilgiTip $type
 * @property-read KonuBilgi    $subSubject
 *
 * @method static Builder|KonuBilgi filter(array $filters = [])
 */
class KonuBilgi extends AbstractModel
{
    protected $table = 'crm.dbo.konu_bilgi';

    use RecorderTrait;

    /**
     * @return hasOne
     */
    public function type(): hasOne
    {
        return $this->hasOne(KonuBilgiTip::class, 'tipid', 'tip');
    }

    /**
     * @return HasMany
     */
    public function subSubject(): hasMany
    {
        return $this->hasMany(KonuBilgi::class, 'ust_id', 'id')
                    ->with('subSubject')
                    ->active()
                    ->where('kullanim_durum', '=', Status::ACTIVE);
    }

    /**
     * @param $filters
     *
     * @return SubjectInformationFilter
     */
    protected function filter($filters): SubjectInformationFilter
    {
        return new SubjectInformationFilter($filters);
    }
}
