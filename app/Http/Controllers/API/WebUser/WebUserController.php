<?php

namespace App\Http\Controllers\API\WebUser;

use App\Enums\DefaultConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebUser\IndexWebUserRequest;
use App\Models\WebUser\WebUser;
use Illuminate\Http\JsonResponse;

class WebUserController extends Controller
{
    /**
     * @param IndexWebUserRequest $request
     * @return mixed
     */
    public function index(IndexWebUserRequest $request): mixed
    {
        $webUser = WebUser::getModel();

        return $webUser->filter($request->all())
            ->select([
                $webUser->getQualifiedKeyName(),
                $webUser->qualifyColumn('ad'),
                $webUser->qualifyColumn('soyad'),
                $webUser->qualifyColumn('ceptel'),
                $webUser->qualifyColumn('kullanici_tipi'),
                $webUser->qualifyColumn('tckimlik'),
                $webUser->qualifyColumn('abone_no'),
                $webUser->qualifyColumn('abonetip'),
                $webUser->qualifyColumn('kurumadi'),
            ])
            ->orderByRaw('ad', 'COLLATE Turkish_CI_AS')
            ->orderByRaw('soyad', 'COLLATE Turkish_CI_AS')
            ->orderByRaw('kurumadi', 'COLLATE Turkish_CI_AS')
            ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
            ->get();
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $webUser = WebUser::findOrFail($id);
        return response()->json(['data' => $webUser]);
    }
}
