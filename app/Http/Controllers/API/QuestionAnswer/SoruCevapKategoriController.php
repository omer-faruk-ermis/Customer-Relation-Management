<?php

namespace App\Http\Controllers\API\QuestionAnswer;

use App\Enums\Status;
use App\Exceptions\QuestionAnswer\QuestionAnswerCategoryNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswerCategory\IndexQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\StoreQuestionAnswerCategoryRequest;
use App\Http\Requests\QuestionAnswerCategory\UpdateQuestionAnswerCategoryRequest;
use App\Models\QuestionAnswer\SoruCevapKategori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SoruCevapKategoriController extends Controller
{
    /**
     * @param IndexQuestionAnswerCategoryRequest $request
     * @return mixed
     */
    public function index(IndexQuestionAnswerCategoryRequest $request): mixed
    {
        return response()->json([
            'message' => true,
            'data'    => SoruCevapKategori::where('kategori_durum', '=', Status::ACTIVE)->get()
        ], Response::HTTP_OK);
    }

    /**
     * @param StoreQuestionAnswerCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreQuestionAnswerCategoryRequest $request): JsonResponse
    {
        $category = SoruCevapKategori::create([
            'kategori_adi'   => $request->category_name,
            'kategori_durum' => Status::ACTIVE,
        ]);

        return response()->json([
            'message' => 'Kategori başarıyla oluşturuldu.',
            'data' => $category
        ], Response::HTTP_CREATED);
    }

    /**
     * @param UpdateQuestionAnswerCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function update(UpdateQuestionAnswerCategoryRequest $request, int $id): JsonResponse
    {
        $category = SoruCevapKategori::findOrFail($id);
        if (empty($category)) {
            return throw new QuestionAnswerCategoryNotFoundException();
        }

        $category->update(['kategori_adi' => $request->category_name]);

        return response()->json([
            'message' => 'Kategori başarıyla güncellendi.',
            'data' => $category
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws QuestionAnswerCategoryNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        $soruCevapKategori = SoruCevapKategori::findOrFail($id);
        if (empty($soruCevapKategori)) {
            return throw new QuestionAnswerCategoryNotFoundException();
        }

        $soruCevapKategori->kategori_durum = Status::PASSIVE;
        $soruCevapKategori->update();

        return response()->json('Kategori Başarıyla silindi.', Response::HTTP_OK);
    }
}
