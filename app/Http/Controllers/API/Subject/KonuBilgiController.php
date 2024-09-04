<?php

namespace App\Http\Controllers\API\Subject;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\IndexSubjectInformationRequest;
use App\Http\Resources\Subject\SubjectInformationCollection;
use App\Services\Subject\SubjectInformationService;
use Illuminate\Http\Request;

/**
 * Class KonuBilgiController
 *
 * @package App\Http\Controllers\API\Subject
 */
class KonuBilgiController extends Controller
{
    /** @var SubjectInformationService $subjectInformationService */
    private SubjectInformationService $subjectInformationService;

    /**
     * KonuBilgiController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->subjectInformationService = new SubjectInformationService($request);
    }

    /**
     * @param IndexSubjectInformationRequest  $request
     *
     * @return SubjectInformationCollection
     */
    public function index(IndexSubjectInformationRequest $request): SubjectInformationCollection
    {
        $subjectInformationService = $this->subjectInformationService->index($request);

        return new SubjectInformationCollection($subjectInformationService, __('messages.' . self::class . '.INDEX'));
    }
}
