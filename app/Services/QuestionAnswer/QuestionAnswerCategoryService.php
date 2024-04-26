<?php

namespace App\Services\QuestionAnswer;

use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Exceptions\QuestionAnswer\QuestionAnswerNotFoundException;
use App\Http\Requests\QuestionAnswer\IndexQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\StoreQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\UpdateQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswerCategory\IndexQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\StoreQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\UpdateQuestionAnswerCategoryRequest;
use App\Models\QuestionAnswer\SoruCevap;
use App\Models\QuestionAnswer\SoruCevapKategori;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class QuestionAnswerCategoryService
 *
 * @package App\Service\QuestionAnswer
 */
class QuestionAnswerCategoryService
{
    /**
     * @param IndexQuestionAnswerCategoryRequest  $request
     *
     * @return Builder[]|Collection|SoruCevapKategori[]
     */
    public function index(IndexQuestionAnswerCategoryRequest $request): array|Collection
    {
        return SoruCevapKategori::where('kategori_durum', '=', Status::ACTIVE)->get();
    }

    /**
     * @param StoreQuestionAnswerCategoryRequest $request
     *
     * @return SoruCevapKategori
     */
    public function store(StoreQuestionAnswerCategoryRequest $request): SoruCevapKategori
    {
        return SoruCevapKategori::create([
            'kategori_adi'   => $request->input('category_name'),
            'kategori_durum' => Status::ACTIVE,
        ]);
    }


    /**
     * @param UpdateQuestionAnswerCategoryRequest $request
     * @param int $id
     *
     * @return SoruCevapKategori
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function update(UpdateQuestionAnswerCategoryRequest $request, int $id): SoruCevapKategori
    {
        $category = SoruCevapKategori::findOrFail($id);
        if (empty($category)) {
            throw new QuestionAnswerCategoryNotFoundException();
        }

        $category->update(['kategori_adi' => $request->input('category_name')]);

        return $category;
    }

    /**
     * @param int $id
     *
     * @return void
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function destroy(int $id): void
    {
        $questionAnswerCategory = SoruCevapKategori::findOrFail($id);
        if (empty($questionAnswerCategory)) {
            throw new QuestionAnswerCategoryNotFoundException();
        }

        $questionAnswerCategory->kategori_durum = Status::PASSIVE;
        $questionAnswerCategory->update();
    }
}
