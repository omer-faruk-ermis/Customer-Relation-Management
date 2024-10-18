<?php

namespace App\Services\Subscriber;

use App\Enums\CustomerPriority;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Subscriber\CustomerPriorityNotFoundException;
use App\Exceptions\Subscriber\SpecialCustomerAlreadyHaveException;
use App\Exceptions\Subscriber\SpecialCustomerNotFoundException;
use App\Models\Subscriber\VipOzelMusteriEslestir;
use App\Services\AbstractService;
use App\Utils\DateUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class CustomerPriorityService
 *
 * @package App\Service\Subscriber
 */
class CustomerPriorityService extends AbstractService
{
    /**
     * @param Request  $request
     *
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        return VipOzelMusteriEslestir::with(['webUser', 'sip'])
                                     ->filter($request->all())
                                     ->active()
                                     ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws SpecialCustomerAlreadyHaveException
     */
    public function store(Request $request): void
    {
        if ($request->input('type') === CustomerPriority::SPECIAL) {
            $specialCustomer =
                VipOzelMusteriEslestir::with(['webUser', 'sip'])
                                      ->filter($request->all())
                                      ->active()
                                      ->first();

            if (!empty($specialCustomer)) {
                throw new SpecialCustomerAlreadyHaveException();
            }
        }

        VipOzelMusteriEslestir::create([
                                           'dahili' => $request->input('sip'),
                                           'userid' => $request->input('web_user_id'),

                                           'aciklama' => $request->input('description'),
                                           'tip'      => $request->input('type'),

                                           'durum' => Status::ACTIVE,
                                           'tarih' => DateUtil::now(),
                                       ]);
    }

    /**
     * @param Request  $request
     * @param string   $id
     *
     * @return VipOzelMusteriEslestir
     * @throws SpecialCustomerNotFoundException
     */
    public function update(Request $request, string $id): VipOzelMusteriEslestir
    {
        $specialCustomer = VipOzelMusteriEslestir::find($id);
        if (empty($specialCustomer)) {
            throw new SpecialCustomerNotFoundException();
        }

        $specialCustomer->update([
                                     'userid'   => $request->input('web_user_id', $specialCustomer->userid),
                                     'dahili'   => $request->input('sip', $specialCustomer->dahili),
                                     'aciklama' => $request->input('description', $specialCustomer->aciklama)
                                 ]);

        return $specialCustomer;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws CustomerPriorityNotFoundException
     */
    public function destroy(string $id): void
    {
        $specialCustomer = VipOzelMusteriEslestir::find($id);
        if (empty($specialCustomer)) {
            throw new CustomerPriorityNotFoundException();
        }

        $specialCustomer->durum = Status::PASSIVE;
        $specialCustomer->update();
    }
}
