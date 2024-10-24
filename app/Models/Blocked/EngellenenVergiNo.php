<?php

namespace App\Models\Blocked;

use App\Filters\Blocked\BlockedTaxIdentificationNoFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class EngellenenVergiNo
 *
 * @package App\Models\Blocked
 * @version October 22, 2024, 07:52 am UTC
 *
 * @property int    $id
 * @property int    $vergino
 * @property string $kayit_tar
 * @property string $kayit_ip
 * @property int    $kayit_id
 * @property string $aciklama
 */
class EngellenenVergiNo extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.engellenen_vergino';

    use RecorderTrait;

    protected $fillable = [
        'vergino',
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
        return $this->hasMany(WebUser::class, 'vergino', 'vergino');
    }

    /**
     * @param $filters
     *
     * @return BlockedTaxIdentificationNoFilter
     */
    protected function filter($filters): BlockedTaxIdentificationNoFilter
    {
        return new BlockedTaxIdentificationNoFilter($filters);
    }
}
