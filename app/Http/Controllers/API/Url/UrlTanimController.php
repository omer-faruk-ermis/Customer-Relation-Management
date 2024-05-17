<?php

namespace App\Http\Controllers\API\Url;

use App\Exceptions\Url\UrlDefinitionNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Url\IndexUrlDefinitionRequest;
use App\Http\Requests\Url\StoreUrlDefinitionRequest;
use App\Http\Requests\Url\UpdateUrlDefinitionRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Url\UrlDefinitionCollection;
use App\Http\Resources\Url\UrlDefinitionResource;
use App\Services\Url\UrlDefinitionService;
use Exception;
use Illuminate\Http\Response;

/**
 * Class UrlTanimController
 *
 * @package App\Http\Controllers\API\Url
 */
class UrlTanimController extends Controller
{
    /** @var UrlDefinitionService $urlDefinitionService */
    private UrlDefinitionService $urlDefinitionService;

    /**
     * UrlTanimController constructor
     */
    public function __construct()
    {
        $this->urlDefinitionService = new UrlDefinitionService();
    }

    /**
     * @param IndexUrlDefinitionRequest  $request
     *
     * @return UrlDefinitionCollection
     */
    public function page(IndexUrlDefinitionRequest $request): UrlDefinitionCollection
    {
        $urlDefinition = $this->urlDefinitionService->page($request);

        return new UrlDefinitionCollection($urlDefinition, 'SMS_MANAGEMENT_PAGE.INDEX.SUCCESS');
    }

    /**
     * @param StoreUrlDefinitionRequest  $request
     *
     * @return UrlDefinitionResource
     * @throws Exception
     */
    public function store(StoreUrlDefinitionRequest $request): UrlDefinitionResource
    {
        $urlDefinition = $this->urlDefinitionService->store($request);

        return new UrlDefinitionResource($urlDefinition, 'SMS_MANAGEMENT_PAGE.STORE.SUCCESS', Response::HTTP_CREATED);
    }

    /**
     * @param UpdateUrlDefinitionRequest  $request
     * @param string                      $id
     *
     * @return UrlDefinitionResource
     * @throws UrlDefinitionNotFoundException
     */
    public function update(UpdateUrlDefinitionRequest $request, string $id): UrlDefinitionResource
    {
        $employee = $this->urlDefinitionService->update($request, $id);

        return new UrlDefinitionResource($employee, 'SMS_MANAGEMENT_PAGE.UPDATE.SUCCESS');
    }

    /**
     * @param string  $id
     *
     * @return SuccessResource
     * @throws UrlDefinitionNotFoundException
     */
    public function destroy(string $id): SuccessResource
    {
        $this->urlDefinitionService->destroy($id);

        return new SuccessResource('SMS_MANAGEMENT_PAGE.DESTROY.SUCCESS');
    }
}
