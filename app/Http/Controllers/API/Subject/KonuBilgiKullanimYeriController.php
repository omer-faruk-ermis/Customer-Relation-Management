<?php

namespace App\Http\Controllers\API\Subject;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\IndexSubjectInformationUsePlaceRequest;
use App\Http\Resources\Subject\SubjectInformationUsePlaceCollection;
use App\Services\Subject\SubjectInformationUsePlaceService;
use Illuminate\Http\Request;

/**
 * Class KonuBilgiKullanimYeriController
 *
 * @package App\Http\Controllers\API\Subject
 */
class KonuBilgiKullanimYeriController extends Controller
{
    /** @var SubjectInformationUsePlaceService $subjectInformationUsePlaceService */
    private SubjectInformationUsePlaceService $subjectInformationUsePlaceService;

    /**
     * KonuBilgiKullanimYeriController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->subjectInformationUsePlaceService = new SubjectInformationUsePlaceService($request);
    }

    /**
     * @param IndexSubjectInformationUsePlaceRequest  $request
     *
     * @return SubjectInformationUsePlaceCollection
     */
    public function index(IndexSubjectInformationUsePlaceRequest $request): SubjectInformationUsePlaceCollection
    {
        $subjectInformationUsePlaceService = $this->subjectInformationUsePlaceService->index($request);

        return new SubjectInformationUsePlaceCollection($subjectInformationUsePlaceService, 'SUBJECT_INFORMATION_USE_PLACE.INDEX.SUCCESS');
    }
}
