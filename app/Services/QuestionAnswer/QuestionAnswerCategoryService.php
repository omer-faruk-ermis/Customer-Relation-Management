<?php

namespace App\Services\QuestionAnswer;

use App\Constants\WidgetId;
use App\Enums\Status;
use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Http\Requests\QuestionAnswerCategory\IndexQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\StoreQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\UpdateQuestionAnswerCategoryRequest;
use App\Models\QuestionAnswer\SoruCevapKategori;
use App\Services\AbstractService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class QuestionAnswerCategoryService
 *
 * @package App\Service\QuestionAnswer
 */
class QuestionAnswerCategoryService extends AbstractService
{
    protected array $privateMethods = [
        'index' => WidgetId::QUICKLY_QUESTION_ANSWER
    ];

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
     * @param StoreQuestionAnswerCategoryRequest  $request
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
     * @param UpdateQuestionAnswerCategoryRequest  $request
     * @param string                               $id
     *
     * @return SoruCevapKategori
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function update(UpdateQuestionAnswerCategoryRequest $request, string $id): SoruCevapKategori
    {
        $category = SoruCevapKategori::find($id);
        if (empty($category)) {
            throw new QuestionAnswerCategoryNotFoundException();
        }

        $category->update(['kategori_adi' => $request->input('category_name')]);

        return $category;
    }

    /**
     * @param string  $id
     *
     * @return void
     *
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function destroy(string $id): void
    {
        $questionAnswerCategory = SoruCevapKategori::find($id);
        if (empty($questionAnswerCategory)) {
            throw new QuestionAnswerCategoryNotFoundException();
        }

        $questionAnswerCategory->kategori_durum = Status::PASSIVE;
        $questionAnswerCategory->update();
    }
}
