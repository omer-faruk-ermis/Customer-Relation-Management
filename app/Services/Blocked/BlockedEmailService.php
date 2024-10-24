<?php

namespace App\Services\Blocked;

use App\Enums\DefaultConstant;
use App\Exceptions\Blocked\BlockedEmailAlreadyHaveException;
use App\Exceptions\Blocked\BlockedEmailNotFoundException;
use App\Models\Blocked\EngellenenMail;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlockedEmailService
 *
 * @package App\Service\Blocked
 */
class BlockedEmailService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return EngellenenMail::with(['subscriber', 'recorder'])
                             ->filter($request->all())
                             ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws BlockedEmailAlreadyHaveException
     */
    public function store(Request $request): void
    {
        $blockedEmail = EngellenenMail::where('mail', $request->input('email'))->first();
        if (!empty($blockedEmail)) {
            throw new BlockedEmailAlreadyHaveException();
        }

        EngellenenMail::create([
                                   'mail'     => $request->input('email'),
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
     * @throws BlockedEmailNotFoundException
     */
    public function destroy(string $id): void
    {
        $blockedEmail = EngellenenMail::find($id);
        if (empty($blockedEmail)) {
            throw new BlockedEmailNotFoundException();
        }

        $blockedEmail->delete();
    }
}
