<?php

namespace App\Http\Controllers\API\QuestionAnswer;

use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswerCategory\IndexQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\StoreQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\UpdateQuestionAnswerCategoryRequest;
use App\Http\Resources\QuestionAnswer\QuestionAnswerCategoryCollection;
use App\Http\Resources\QuestionAnswer\QuestionAnswerCategoryResource;
use App\Http\Resources\SuccessResource;
use App\Services\QuestionAnswer\QuestionAnswerCategoryService;
use Illuminate\Http\Response;

/**
 * Class SoruCevapKategoriController
 *
 * @package App\Http\Controllers\API\QuestionAnswer
 */
class SoruCevapKategoriController extends Controller
{
    /** @var QuestionAnswerCategoryService $questionAnswerService */
    private QuestionAnswerCategoryService $questionAnswerCategoryService;

    /**
     * SoruCevapKategoriController constructor
     */
    public function __construct()
    {
        $this->questionAnswerCategoryService = new QuestionAnswerCategoryService();
    }

    /**
     * @param IndexQuestionAnswerCategoryRequest $request
     *
     * @return QuestionAnswerCategoryCollection
     */
    public function index(IndexQuestionAnswerCategoryRequest $request): QuestionAnswerCategoryCollection
    {
        $questionAnswerCategories = $this->questionAnswerCategoryService->index($request);

        return new QuestionAnswerCategoryCollection($questionAnswerCategories, 'QUESTION_ANSWER_CATEGORY.INDEX.SUCCESS');
    }

    /**
     * @param StoreQuestionAnswerCategoryRequest $request
     *
     * @return QuestionAnswerCategoryResource
     */
    public function store(StoreQuestionAnswerCategoryRequest $request): QuestionAnswerCategoryResource
    {
        $questionAnswerCategories = $this->questionAnswerCategoryService->store($request);

        return new QuestionAnswerCategoryResource($questionAnswerCategories, 'QUESTION_ANSWER_CATEGORY.CREATE.SUCCESS', Response::HTTP_CREATED);
    }

    /**
     * @param UpdateQuestionAnswerCategoryRequest $request
     * @param int $id
     *
     * @return QuestionAnswerCategoryResource
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function update(UpdateQuestionAnswerCategoryRequest $request, int $id): QuestionAnswerCategoryResource
    {
        $questionAnswerCategories = $this->questionAnswerCategoryService->update($request, $id);

        return new QuestionAnswerCategoryResource($questionAnswerCategories, 'QUESTION_ANSWER_CATEGORY.UPDATE.SUCCESS');
    }

    /**
     * @param int $id
     *
     * @return SuccessResource
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function destroy(int $id): SuccessResource
    {
        $this->questionAnswerCategoryService->destroy($id);

        return new SuccessResource('QUESTION_ANSWER_CATEGORY.DESTROY.SUCCESS');
    }
}
