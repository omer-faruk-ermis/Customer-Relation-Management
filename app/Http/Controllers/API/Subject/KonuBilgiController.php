<?php

namespace App\Http\Controllers\API\Subject;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Subject\SubjectInformationNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\IndexSubjectInformationRequest;
use App\Http\Requests\Subject\StoreSubjectInformationRequest;
use App\Http\Requests\Subject\UpdateSubjectInformationRequest;
use App\Http\Resources\Subject\SubjectInformationCollection;
use App\Http\Resources\Subject\SubjectInformationResource;
use App\Http\Resources\SuccessResource;
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
        $subjectInformation = $this->subjectInformationService->index($request);

        return new SubjectInformationCollection($subjectInformation, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreSubjectInformationRequest  $request
     *
     * @return SuccessResource
     */
    public function store(StoreSubjectInformationRequest $request): SuccessResource
    {
        $this->subjectInformationService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param UpdateSubjectInformationRequest  $request
     * @param string                               $id
     *
     * @return SubjectInformationResource
     *
     * @throws SubjectInformationNotFoundException
     */
    public function update(UpdateSubjectInformationRequest $request, string $id): SubjectInformationResource
    {
        $subjectInformation = $this->subjectInformationService->update($request, $id);

        return new SubjectInformationResource($subjectInformation, __('messages.' . self::class . '.UPDATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws SubjectInformationNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->subjectInformationService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
