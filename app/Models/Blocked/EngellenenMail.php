<?php

namespace App\Models\Blocked;

use App\Filters\Blocked\BlockedEmailFilter;
use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class EngellenenMail
 *
 * @package App\Models\Blocked
 * @version October 15, 2024, 11:36 am UTC
 *
 * @property int    $id
 * @property string $mail
 * @property string $kayit_tar
 * @property string $kayit_ip
 * @property int    $kayit_id
 * @property string $aciklama
 */
class EngellenenMail extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.engellenen_mail';

    use RecorderTrait;

    protected $fillable = [
        'mail',
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
        return $this->hasMany(WebUser::class, 'email', 'mail');
    }

    /**
     * @param $filters
     *
     * @return BlockedEmailFilter
     */
    protected function filter($filters): BlockedEmailFilter
    {
        return new BlockedEmailFilter($filters);
    }
}
