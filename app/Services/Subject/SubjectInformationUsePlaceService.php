<?php

namespace App\Services\Subject;

use App\Models\Subject\KonuBilgiKullanimYeri;
use App\Services\AbstractService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class SubjectInformationUsePlaceService
 *
 * @package App\Service\Subject
 */
class SubjectInformationUsePlaceService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return KonuBilgiKullanimYeri::active()->get();
    }
}
