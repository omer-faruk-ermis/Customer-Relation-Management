<?php

namespace App\Http\Controllers\API\Url;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Url\UrlDefinitionNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Url\IndexUrlDefinitionRequest;
use App\Http\Requests\Url\StoreUrlDefinitionRequest;
use App\Http\Requests\Url\UpdateUrlDefinitionRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Url\UrlDefinitionCollection;
use App\Http\Resources\Url\UrlDefinitionResource;
use App\Services\Url\UrlDefinitionService;
use Exception;
use Illuminate\Http\Request;
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
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->urlDefinitionService = new UrlDefinitionService($request);
    }

    /**
     * @param IndexUrlDefinitionRequest  $request
     *
     * @return UrlDefinitionCollection|PaginationResource
     */
    public function page(IndexUrlDefinitionRequest $request): UrlDefinitionCollection|PaginationResource
    {
        $urlDefinition = $this->urlDefinitionService->page($request);

        return $request->input('page')
            ? new PaginationResource($urlDefinition, __('messages.' . self::class . '.INDEX'))
            : new UrlDefinitionCollection($urlDefinition, __('messages.' . self::class . '.INDEX'));
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

        return new UrlDefinitionResource($urlDefinition, __('messages.' . self::class . '.CREATE'), Response::HTTP_CREATED);
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

        return new UrlDefinitionResource($employee, __('messages.' . self::class . '.UPDATE'));
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

        return new SuccessResource(__('messages.' . self::class . '.DESTROY'));
    }
}
