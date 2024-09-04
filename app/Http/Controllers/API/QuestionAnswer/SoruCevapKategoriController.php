<?php

namespace App\Http\Controllers\API\QuestionAnswer;

use App\Exceptions\ForbiddenException;
use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswerCategory\IndexQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\StoreQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\UpdateQuestionAnswerCategoryRequest;
use App\Http\Resources\QuestionAnswer\QuestionAnswerCategoryCollection;
use App\Http\Resources\QuestionAnswer\QuestionAnswerCategoryResource;
use App\Http\Resources\SuccessResource;
use App\Services\QuestionAnswer\QuestionAnswerCategoryService;
use Illuminate\Http\Request;
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
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->questionAnswerCategoryService = new QuestionAnswerCategoryService($request);
    }

    /**
     * @param IndexQuestionAnswerCategoryRequest  $request
     *
     * @return QuestionAnswerCategoryCollection
     */
    public function index(IndexQuestionAnswerCategoryRequest $request): QuestionAnswerCategoryCollection
    {
        $questionAnswerCategories = $this->questionAnswerCategoryService->index($request);

        return new QuestionAnswerCategoryCollection($questionAnswerCategories, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreQuestionAnswerCategoryRequest  $request
     *
     * @return QuestionAnswerCategoryResource
     */
    public function store(StoreQuestionAnswerCategoryRequest $request): QuestionAnswerCategoryResource
    {
        $questionAnswerCategories = $this->questionAnswerCategoryService->store($request);

        return new QuestionAnswerCategoryResource($questionAnswerCategories, __('messages.' . self::class . '.CREATE'), Response::HTTP_CREATED);
    }

    /**
     * @param UpdateQuestionAnswerCategoryRequest  $request
     * @param string                               $id
     *
     * @return QuestionAnswerCategoryResource
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function update(UpdateQuestionAnswerCategoryRequest $request, string $id): QuestionAnswerCategoryResource
    {
        $questionAnswerCategorY = $this->questionAnswerCategoryService->update($request, $id);

        return new QuestionAnswerCategoryResource($questionAnswerCategorY, __('messages.' . self::class . '.UPDATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->questionAnswerCategoryService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
