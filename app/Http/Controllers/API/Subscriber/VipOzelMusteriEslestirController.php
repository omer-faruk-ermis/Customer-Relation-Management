<?php

namespace App\Http\Controllers\API\Subscriber;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Subscriber\CustomerPriorityNotFoundException;
use App\Exceptions\Subscriber\SpecialCustomerAlreadyHaveException;
use App\Exceptions\Subscriber\SpecialCustomerNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\IndexCustomerPriorityRequest;
use App\Http\Requests\Subscriber\StoreCustomerPriorityRequest;
use App\Http\Requests\Subscriber\UpdateCustomerPriorityRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Subscriber\CustomerPriorityResource;
use App\Http\Resources\SuccessResource;
use App\Services\Subscriber\CustomerPriorityService;
use Illuminate\Http\Request;

/**
 * Class VipOzelMusteriEslestirController
 *
 * @package App\Http\Controllers\API\Subscriber
 */
class VipOzelMusteriEslestirController extends Controller
{
    /** @var CustomerPriorityService $customerPriorityService */
    private CustomerPriorityService $customerPriorityService;

    /**
     * VipOzelMusteriEslestirController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->customerPriorityService = new CustomerPriorityService($request);
    }

    /**
     * @param IndexCustomerPriorityRequest  $request
     *
     * @return PaginationResource
     */
    public function index(IndexCustomerPriorityRequest $request): PaginationResource
    {
        $customerPriority = $this->customerPriorityService->index($request);

        return new PaginationResource($customerPriority, __('messages.' . self::class . '.INDEX'));
    }

    /**
     * @param StoreCustomerPriorityRequest  $request
     *
     * @return SuccessResource
     * @throws SpecialCustomerAlreadyHaveException
     */
    public function store(StoreCustomerPriorityRequest $request): SuccessResource
    {
        $this->customerPriorityService->store($request);

        return new SuccessResource(__('messages.' . self::class . '.CREATE'));
    }

    /**
     * @param UpdateCustomerPriorityRequest  $request
     * @param string                      $id
     *
     * @return CustomerPriorityResource
     * @throws SpecialCustomerNotFoundException
     */
    public function update(UpdateCustomerPriorityRequest $request, string $id): CustomerPriorityResource
    {
        $customerPriority = $this->customerPriorityService->update($request, $id);

        return new CustomerPriorityResource($customerPriority, __('messages.' . self::class . '.UPDATE'));
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws CustomerPriorityNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->customerPriorityService->destroy($id);

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
