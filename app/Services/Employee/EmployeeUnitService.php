<?php

namespace App\Services\Employee;

use App\Enums\Status;
use App\Http\Requests\Employee\IndexEmployeeUnitRequest;
use App\Models\SmsKimlik\SmsKimlikBirim;
use Illuminate\Support\Collection;

/**
 * Class EmployeeUnitService
 *
 * @package App\Service\Employee
 */
class EmployeeUnitService
{
    /**
     * @param IndexEmployeeUnitRequest $request
     * @return Collection
     */
    public function index(IndexEmployeeUnitRequest $request): Collection
    {
        return SmsKimlikBirim::where('durum', '=', Status::ACTIVE)->get();
    }
}
