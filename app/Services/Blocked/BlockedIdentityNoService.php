<?php

namespace App\Services\Blocked;

use App\Enums\DefaultConstant;
use App\Exceptions\Blocked\BlockedIdentityNoAlreadyHaveException;
use App\Exceptions\Blocked\BlockedIdentityNoNotFoundException;
use App\Models\Blocked\EngellenenKimlikNo;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlockedIdentityNoService
 *
 * @package App\Service\Blocked
 */
class BlockedIdentityNoService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return EngellenenKimlikNo::with(['recorder','subscriber'])
                                 ->filter($request->all())
                                 ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws BlockedIdentityNoAlreadyHaveException
     */
    public function store(Request $request): void
    {
        $blockedIdentityNo = EngellenenKimlikNo::where('kimlikno', $request->input('identity_no'))->first();
        if (!empty($blockedIdentityNo)) {
            throw new BlockedIdentityNoAlreadyHaveException();
        }

        EngellenenKimlikNo::create([
                                       'kimlikno' => $request->input('identity_no'),
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
     * @throws BlockedIdentityNoNotFoundException
     */
    public function destroy(string $id): void
    {
        $blockedIdentityNo = EngellenenKimlikNo::find($id);
        if (empty($blockedIdentityNo)) {
            throw new BlockedIdentityNoNotFoundException();
        }

        $blockedIdentityNo->delete();
    }
}
