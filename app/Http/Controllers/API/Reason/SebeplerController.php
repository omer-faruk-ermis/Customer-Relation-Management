<?php

namespace App\Http\Controllers\API\Reason;

use App\Enums\DefaultConstant;
use App\Http\Controllers\Controller;
use App\Models\Sebep\Sebepler;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SebeplerController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Sebepler::limit(DefaultConstant::SEARCH_LIST_LIMIT)->get();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function basic(Request $request)
    {
        $sebepler = Sebepler::getModel();

        return DB::table($sebepler->getTable())
            ->select(
                $sebepler->getQualifiedKeyName(),
                $sebepler->qualifyColumn('ust_id'),
                $sebepler->qualifyColumn('aciklama'),
            )
            ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
            ->get();
    }
}
