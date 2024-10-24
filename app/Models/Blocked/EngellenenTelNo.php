<?php

namespace App\Models\Blocked;

use App\Filters\Blocked\BlockedPhoneFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class EngellenenTelNo
 *
 * @package App\Models\Blocked
 * @version October 15, 2024, 11:36 am UTC
 *
 * @property int    $id
 * @property string $telno
 * @property string $kayit_tar
 * @property string $kayit_ip
 * @property int    $kayit_id
 * @property string $aciklama
 */
class EngellenenTelNo extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.engellenen_telno';

    use RecorderTrait;

    protected $fillable = [
        'telno',
        'kayit_tar',
        'kayit_ip',
        'kayit_id',
        'aciklama',
    ];

    /**
     * @return hasMany
     */
    public function subscriber(): hasMany
    {
        return $this->hasMany(WebUser::class, 'ceptel', 'telno');
    }

    /**
     * @param $filters
     *
     * @return BlockedPhoneFilter
     */
    protected function filter($filters): BlockedPhoneFilter
    {
        return new BlockedPhoneFilter($filters);
    }
}
