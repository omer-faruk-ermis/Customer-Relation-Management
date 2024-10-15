<?php

namespace App\Services\Subject;

use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Subject\SubjectInformationNotFoundException;
use App\Models\Subject\KonuBilgi;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class SubjectInformationService
 *
 * @package App\Service\Subject
 */
class SubjectInformationService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        return KonuBilgi::with([
                                   'type',
                                   'recorder',
                                   'subSubject' => function ($q) use ($request) {
                                       $q->filter($request->all());
                                   }])
                        ->filter($request->all())
                        ->where('kullanim_yeri', '=', $request->input('use_place_id'))
                        ->where('ust_id', '=', DefaultConstant::PARENT)
                        ->active()
                        ->orderBy('ad')
                        ->get();
    }

    /**
     * @param Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        KonuBilgi::create([
                              'ad'       => $request->input('name'),
                              'aciklama' => $request->input('description'),

                              'tip'            => KonuBilgi::find($request->input('parent_id'))->tip + 1,
                              'kullanim_yeri'  => $request->input('use_place_id'),
                              'kullanici_tipi' => $request->input('user_type_ids'),
                              'ust_id'         => $request->input('parent_id'),

                              'durum'          => Status::ACTIVE,
                              'kullanim_durum' => Status::ACTIVE,

                              'kayit_id'  => Auth::id(),
                              'kayit_ip'  => $request->ip(),
                              'kayit_tar' => DateUtil::now(),
                          ]);
    }


    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return KonuBilgi
     *
     * @throws SubjectInformationNotFoundException
     */
    public function update(Request $request, string $id): KonuBilgi
    {
        $subjectInformation = KonuBilgi::find($id);
        if (empty($subjectInformation)) {
            throw new SubjectInformationNotFoundException();
        }

        $subjectInformation->update([
                                        'ad'             => $request->input('name', $subjectInformation->ad),
                                        'aciklama'       => $request->input('description', $subjectInformation->aciklama),
                                        'kullanim_durum' => $request->input('use_state', $subjectInformation->kullanim_durum),

                                        'kullanim_yeri'  => $request->input('use_place_id', $subjectInformation->kullanim_yeri),
                                        'kullanici_tipi' => $request->input('user_type_ids', $subjectInformation->kullanici_tipi),
                                    ]);

        return $subjectInformation;
    }

    /**
     * @param string  $id
     *
     * @return void
     *
     * @throws SubjectInformationNotFoundException
     */
    public function destroy(string $id): void
    {
        $subjectInformation = KonuBilgi::find($id);
        if (empty($subjectInformation)) {
            throw new SubjectInformationNotFoundException();
        }

        $subjectInformation->durum = Status::PASSIVE;
        $subjectInformation->update();
    }
}
