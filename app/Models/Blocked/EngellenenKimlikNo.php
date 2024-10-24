<?php

namespace App\Models\Blocked;

use App\Filters\Blocked\BlockedIdentityNoFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EngellenenKimlikNo
 *
 * @package App\Models\Blocked
 * @version October 15, 2024, 11:36 am UTC
 *
 * @property int          $id
 * @property int          $kimlikno
 * @property string       $kayit_tar
 * @property string       $kayit_ip
 * @property int          $kayit_id
 * @property string       $aciklama
 *
 * @property-read WebUser $subscriber
 *
 * @method static Builder|EngellenenKimlikNo filter(array $filters = [])
 */
class EngellenenKimlikNo extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.engellenen_kimlikno';

    use RecorderTrait;

    protected $fillable = [
        'kimlikno',
        'kayit_tar',
        'kayit_ip',
        'kayit_id',
        'aciklama',
    ];

    protected $casts = [
      'kimlikno' => 'string'
    ];

    /**
     * @return hasMany
     */
    public function subscriber(): hasMany
    {
        return $this->hasMany(WebUser::class, 'tckimlik', 'kimlikno');
    }

    /**
     * @param $filters
     *
     * @return BlockedIdentityNoFilter
     */
    protected function filter($filters): BlockedIdentityNoFilter
    {
        return new BlockedIdentityNoFilter($filters);
    }
}
