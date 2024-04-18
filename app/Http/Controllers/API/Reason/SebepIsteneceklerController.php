<?php

namespace App\Http\Controllers\API\Reason;

use App\Enums\DefaultConstant;
use App\Http\Controllers\Controller;
use App\Models\Sebep\SebepIstenecekler;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SebepIsteneceklerController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return SebepIstenecekler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function basic(Request $request)
    {
        $sebepIstenecekler = SebepIstenecekler::getModel();

        return DB::table($sebepIstenecekler->getTable())
            ->select(
                $sebepIstenecekler->getQualifiedKeyName(),
                $sebepIstenecekler->qualifyColumn('ifade')
            )
            ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
            ->get();
    }
}
