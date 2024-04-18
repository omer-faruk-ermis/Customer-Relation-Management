<?php

namespace App\Http\Controllers\API\QuestionAnswer;

use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\QuestionAnswer\QuestionAnswerNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionAnswer\IndexQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\StoreQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\UpdateQuestionAnswerRequest;
use App\Models\QuestionAnswer\SoruCevap;
use App\Models\QuestionAnswer\SoruCevapKategori;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SoruCevapController extends Controller
{
    /**
     * @param IndexQuestionAnswerRequest $request
     * @return mixed
     */
    public function index(IndexQuestionAnswerRequest $request): mixed
    {
        $soruCevap = SoruCevap::getModel();
        $soruCevapKategori = SoruCevapKategori::getModel();

        return response()->json([
            'message' => true,
            'data'    =>
                SoruCevap::select([
                    $soruCevap->qualifyAllColumns(),
                    DB::raw($soruCevapKategori->getQualifiedKeyName() . ' AS kategori_id'),
                    $soruCevapKategori->qualifyColumn('kategori_adi'),
                    $soruCevapKategori->qualifyColumn('kategori_durum'),
                ])
                    ->filter($request->all())
                    ->join($soruCevapKategori->getTable(),
                        $soruCevap->qualifyColumn('kategori_id'),
                        '=',
                        $soruCevapKategori->getQualifiedKeyName())
                    ->where($soruCevap->qualifyColumn('durum'), '=', Status::ACTIVE)
                    ->where($soruCevapKategori->qualifyColumn('kategori_durum'), '=', Status::ACTIVE)
                    ->paginate(DefaultConstant::PAGINATE)
        ], Response::HTTP_OK);
    }

    /**
     * @param StoreQuestionAnswerRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreQuestionAnswerRequest $request): JsonResponse
    {
        $soruCevap = SoruCevap::create([
            'kategori_id'    => $request->input('category_id'),
            'soru'           => $request->input('question'),
            'sayac'          => NumericalConstant::ZERO,
            'cevap'          => $request->input('answer'),
            'durum'          => Status::ACTIVE,
            'soru_keywords'  => $request->input('question_keywords'),
            'cevap_keywords' => $request->input('answer_keywords'),
            'kaydeden_ip'    => $request->ip(),
            'kayit_tarih'    => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
        ]);

        return response()->json(['message' => 'Soru-Cevap başarıyla oluşturuldu', 'data' => $soruCevap], Response::HTTP_CREATED);
    }


    /**
     * @param UpdateQuestionAnswerRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws QuestionAnswerNotFoundException
     */
    public function update(UpdateQuestionAnswerRequest $request, int $id): JsonResponse
    {
        $soruCevap = SoruCevap::findOrFail($id);
        if (empty($soruCevap)) {
            return throw new QuestionAnswerNotFoundException();
        }

        $soruCevap->update([
            'kategori_id'    => $request->input('category_id', $soruCevap->kategori_id),
            'soru'           => $request->input('question', $soruCevap->soru),
            'cevap'          => $request->input('answer', $soruCevap->soru),
            'soru_keywords'  => $request->input('question_keywords', $soruCevap->soru_keywords),
            'cevap_keywords' => $request->input('answer_keywords', $soruCevap->cevap_keywords),
        ]);

        return response()->json([
            'message' => 'Soru-Cevap başarıyla güncellendi.',
            'data'    => $soruCevap
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws QuestionAnswerNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        $soruCevap = SoruCevap::findOrFail($id);
        if (empty($soruCevap)) {
            return throw new QuestionAnswerNotFoundException();
        }

        $soruCevap->durum = Status::PASSIVE;
        $soruCevap->update();

        return response()->json('Soru-Cevap Başarıyla silindi.', Response::HTTP_OK);
    }
}
