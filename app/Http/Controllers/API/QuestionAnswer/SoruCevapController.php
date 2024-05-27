<?php

namespace App\Http\Controllers\API\QuestionAnswer;

use App\Exceptions\ForbiddenException;
use App\Exceptions\QuestionAnswer\QuestionAnswerNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswer\IndexQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\StoreQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\UpdateQuestionAnswerRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\QuestionAnswer\QuestionAnswerResource;
use App\Http\Resources\SuccessResource;
use App\Services\QuestionAnswer\QuestionAnswerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SoruCevapController
 *
 * @package App\Http\Controllers\API\QuestionAnswer
 */
class SoruCevapController extends Controller
{
    /** @var QuestionAnswerService $questionAnswerService */
    private QuestionAnswerService $questionAnswerService;

    /**
     * SoruCevapController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->questionAnswerService = new QuestionAnswerService($request);
    }

    /**
     * @param IndexQuestionAnswerRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexQuestionAnswerRequest $request): PaginationResource
    {
        $questionAnswers = $this->questionAnswerService->index($request);

        return new PaginationResource($questionAnswers, 'QUESTION_ANSWER.INDEX.SUCCESS');
    }

    /**
     * @param StoreQuestionAnswerRequest  $request
     *
     * @return QuestionAnswerResource
     *
     * @throws Exception
     */
    public function store(StoreQuestionAnswerRequest $request): QuestionAnswerResource
    {
        $questionAnswers = $this->questionAnswerService->store($request);

        return new QuestionAnswerResource($questionAnswers, 'QUESTION_ANSWER.CREATE.SUCCESS', Response::HTTP_CREATED);
    }

    /**
     * @param UpdateQuestionAnswerRequest  $request
     * @param string                       $id
     *
     * @return QuestionAnswerResource
     *
     * @throws QuestionAnswerNotFoundException
     */
    public function update(UpdateQuestionAnswerRequest $request, string $id): QuestionAnswerResource
    {
        $questionAnswer = $this->questionAnswerService->update($request, $id);

        return new QuestionAnswerResource($questionAnswer, 'QUESTION_ANSWER.UPDATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     *
     * @throws QuestionAnswerNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->questionAnswerService->destroy($id);

        return new SuccessResource('QUESTION_ANSWER.DESTROY.SUCCESS');
    }
}
