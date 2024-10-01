<?php

namespace App\Services\Reason;

use App\Enums\DefaultConstant;
use App\Exceptions\Reason\ReasonNotFoundException;
use App\Models\Sebep\Sebepler;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class ReasonService
 *
 * @package App\Service\Reason
 */
class ReasonService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection
     * @throws Exception
     */
    public function index(Request $request): Collection
    {
        return Sebepler::with('reasonWanted')
                       ->filter($request->all())
                       ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
                       ->get();
    }

    /**
     * @param Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        Sebepler::create([
                             'aciklama' => $request->input('description'),
                             'ust_id'   => $request->input('parent_id', DefaultConstant::HAVE_NOT_REASON_WANTED),
                         ]);
    }

    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return Sebepler
     *
     * @throws ReasonNotFoundException
     */
    public function update(Request $request, string $id): Sebepler
    {
        $reason = Sebepler::find(Security::decrypt($id));
        if (empty($reason)) {
            throw new ReasonNotFoundException();
        }

        $reason->update([
                            'aciklama' => $request->input('description', $reason->aciklama),
                            'ust_id'   => $request->input('parent_id', $reason->ust_id),
                        ]);

        return $reason;
    }
}
