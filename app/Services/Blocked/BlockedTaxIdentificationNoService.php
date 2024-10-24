<?php

namespace App\Services\Blocked;

use App\Enums\DefaultConstant;
use App\Exceptions\Blocked\BlockedTaxIdentificationNoAlreadyHaveException;
use App\Exceptions\Blocked\BlockedTaxIdentificationNoNotFoundException;
use App\Models\Blocked\EngellenenVergiNo;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlockedTaxIdentificationNoService
 *
 * @package App\Service\Blocked
 */
class BlockedTaxIdentificationNoService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return EngellenenVergiNo::with(['subscriber', 'recorder'])
                                ->filter($request->all())
                                ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws BlockedTaxIdentificationNoAlreadyHaveException
     */
    public function store(Request $request): void
    {
        $blockedTaxIdentificationNo = EngellenenVergiNo::where('vergino', $request->input('tax_identification_no'))->first();
        if (!empty($blockedTaxIdentificationNo)) {
            throw new BlockedTaxIdentificationNoAlreadyHaveException();
        }

        EngellenenVergiNo::create([
                                      'vergino'  => $request->input('tax_identification_no'),
                                      'aciklama' => $request->input('description'),

                                      'kayit_id'  => Auth::id(),
                                      'kayit_ip'  => $request->ip(),
                                      'kayit_tar' => DateUtil::now(),
                                  ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws BlockedTaxIdentificationNoNotFoundException
     */
    public function destroy(string $id): void
    {
        $blockedTaxIdentificationNo = EngellenenVergiNo::find($id);
        if (empty($blockedTaxIdentificationNo)) {
            throw new BlockedTaxIdentificationNoNotFoundException();
        }

        $blockedTaxIdentificationNo->delete();
    }
}
