<?php

namespace App\Services\QuestionAnswer;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\QuestionAnswer\QuestionAnswerNotFoundException;
use App\Http\Requests\QuestionAnswer\IndexQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\StoreQuestionAnswerRequest;
use App\Http\Requests\QuestionAnswer\UpdateQuestionAnswerRequest;
use App\Models\QuestionAnswer\SoruCevap;
use App\Models\QuestionAnswer\SoruCevapKategori;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use App\Utils\Security;
use Illuminate\Support\Facades\DB;

/**
 * Class QuestionAnswerService
 *
 * @package App\Service\QuestionAnswer
 */
class QuestionAnswerService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::MANAGEMENT_READY_QUESTION_ANSWERS,
        ],
    ];

    /**
     * @param IndexQuestionAnswerRequest  $request
     *
     * @return mixed
     */
    public function index(IndexQuestionAnswerRequest $request): mixed
    {
        $questionAnswer = SoruCevap::getModel();
        $questionAnswerCategory = SoruCevapKategori::getModel();

        return SoruCevap::with('category')
                        ->select([
                                     $questionAnswer->qualifyAllColumns(),
                                     DB::raw($questionAnswerCategory->getQualifiedKeyName() . ' AS kategori_id'),
                                     $questionAnswerCategory->qualifyColumn('kategori_adi'),
                                     $questionAnswerCategory->qualifyColumn('kategori_durum'),
                                 ])
                        ->filter($request->all())
                        ->join($questionAnswerCategory->getTable(),
                               $questionAnswer->qualifyColumn('kategori_id'),
                               '=',
                               $questionAnswerCategory->getQualifiedKeyName())
                        ->where($questionAnswer->qualifyColumn('durum'), '=', Status::ACTIVE)
                        ->where($questionAnswerCategory->qualifyColumn('kategori_durum'), '=', Status::ACTIVE)
                        ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param StoreQuestionAnswerRequest  $request
     *
     * @return SoruCevap
     */
    public function store(StoreQuestionAnswerRequest $request): SoruCevap
    {
        return SoruCevap::create([
                                     'kategori_id'    => $request->input('category_id'),
                                     'soru'           => $request->input('question'),
                                     'sayac'          => NumericalConstant::ZERO,
                                     'cevap'          => $request->input('answer'),
                                     'durum'          => Status::ACTIVE,
                                     'soru_keywords'  => $request->input('question_keywords'),
                                     'cevap_keywords' => $request->input('answer_keywords'),

                                     'kaydeden_ip'    => $request->ip(),
                                     'kayit_tarih'    => DateUtil::now(),
                                 ]);
    }


    /**
     * @param UpdateQuestionAnswerRequest  $request
     * @param string                       $id
     *
     * @return SoruCevap
     *
     * @throws QuestionAnswerNotFoundException
     */
    public function update(UpdateQuestionAnswerRequest $request, string $id): SoruCevap
    {
        $questionAnswer = SoruCevap::find(Security::decrypt($id));
        if (empty($questionAnswer)) {
            throw new QuestionAnswerNotFoundException();
        }

        $questionAnswer->update([
                                    'kategori_id'    => $request->input('category_id', $questionAnswer->kategori_id),
                                    'soru'           => $request->input('question', $questionAnswer->soru),
                                    'cevap'          => $request->input('answer', $questionAnswer->soru),
                                    'soru_keywords'  => $request->input('question_keywords', $questionAnswer->soru_keywords),
                                    'cevap_keywords' => $request->input('answer_keywords', $questionAnswer->cevap_keywords),
                                ]);

        return $questionAnswer;
    }

    /**
     * @param string  $id
     *
     * @return void
     *
     * @throws QuestionAnswerNotFoundException
     */
    public function destroy(string $id): void
    {
        $questionAnswer = SoruCevap::find(Security::decrypt($id));
        if (empty($questionAnswer)) {
            throw new QuestionAnswerNotFoundException();
        }

        $questionAnswer->durum = Status::PASSIVE;
        $questionAnswer->update();
    }
}
