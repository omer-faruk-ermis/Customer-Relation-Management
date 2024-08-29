<?php

namespace App\Services\Subject;

use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Models\Subject\KonuBilgi;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubjectInformationService
 *
 * @package App\Service\Subject
 */
class SubjectInformationService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return KonuBilgi::with(['type', 'recorder', 'subSubject'])
                        ->where('kullanim_durum', '=', Status::ACTIVE)
                        ->where('kullanim_yeri', '=', $request->input('use_place_id'))
                        ->where('ust_id', '=', DefaultConstant::PARENT)
                        ->where(function ($query) use ($request) {
                            $userType = $request->input('user_type');
                            $query
                                ->where('kullanici_tipi', 'LIKE', '%,' . $userType . ',%')
                                ->orWhere('kullanici_tipi', 'LIKE', $userType . ',%')
                                ->orWhere('kullanici_tipi', 'LIKE', '%,' . $userType)
                                ->orWhere('kullanici_tipi', $userType)
                                ->orWhereNull('kullanici_tipi');
                        })
                        ->active()
                        ->orderBy('ad')
                        ->get();
    }
}
