<?php

namespace App\Services;

use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\DetailMenu\DetailMenuUserNotFoundException;
use App\Exceptions\Staff\StaffGroupMatchAlreadyHaveException;
use App\Exceptions\Staff\StaffGroupMatchNotFoundException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Helpers\CacheOperation;
use Exception;
use Illuminate\Http\Request;

/**
 * Class BulkAuthorizationTrait
 *
 * @package App\Service
 */
trait BulkAuthorizationTrait
{
    /**
     * @param Request  $request
     *
     * @return void
     * @throws EmployeeAuthorizationNotFoundException
     * @throws DetailMenuUserNotFoundException
     * @throws StaffGroupMatchAlreadyHaveException
     * @throws StaffGroupMatchNotFoundException
     * @throws WebPortalAuthorizationPermissionNotFoundException
     * @throws Exception
     */
    public function bulk(Request $request): void
    {
        foreach ($request->input('bulk_authorizations') as $authorization) {
            $authorizationRequest = new Request($authorization);

            if ($authorizationRequest->input('is_authorized')) {
                $this->store($authorizationRequest);
            } else {
                $this->destroy($authorizationRequest);
            }
        }

        CacheOperation::refreshEmployeeSession($request->bearerToken());
    }
}
