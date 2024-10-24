<?php

namespace App\Services\Blocked;

use App\Enums\DefaultConstant;
use App\Exceptions\Blocked\BlockedPhoneAlreadyHaveException;
use App\Exceptions\Blocked\BlockedPhoneNotFoundException;
use App\Models\Blocked\EngellenenTelNo;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlockedPhoneService
 *
 * @package App\Service\Blocked
 */
class BlockedPhoneService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return EngellenenTelNo::with(['subscriber', 'recorder'])
                              ->filter($request->all())
                              ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws BlockedPhoneAlreadyHaveException
     */
    public function store(Request $request): void
    {
        $blockedPhone = EngellenenTelNo::where('telno', $request->input('phone'))->first();
        if (!empty($blockedPhone)) {
            throw new BlockedPhoneAlreadyHaveException();
        }

        EngellenenTelNo::create([
                                    'telno'    => $request->input('phone'),
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
     * @throws BlockedPhoneNotFoundException
     */
    public function destroy(string $id): void
    {
        $blockedPhone = EngellenenTelNo::find($id);
        if (empty($blockedPhone)) {
            throw new BlockedPhoneNotFoundException();
        }

        $blockedPhone->delete();
    }
}
