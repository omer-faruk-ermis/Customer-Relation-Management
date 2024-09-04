<?php

namespace App\Http\Controllers\API\Subscriber;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\IndexSubscriberBilletAuthorizationRequest;
use App\Http\Resources\Subscriber\SubscriberBilletAuthorizationCollection;
use App\Http\Resources\Subscriber\SubscriberBilletMenuAuthorizationResource;
use App\Services\Authorization\SubscriberBilletAuthorizationService;
use Illuminate\Http\Request;

/**
 * Class AboneKutukYetkiController
 *
 * @package App\Http\Controllers\API\Subscriber
 */
class AboneKutukYetkiController extends Controller
{
    /** @var SubscriberBilletAuthorizationService $subscriberBilletAuthorizationService */
    private SubscriberBilletAuthorizationService $subscriberBilletAuthorizationService;

    /**
     * AboneKutukYetkiController constructor
     *
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->subscriberBilletAuthorizationService = new SubscriberBilletAuthorizationService($request);
    }

    /**
     * @param IndexSubscriberBilletAuthorizationRequest  $request
     *
     * @return SubscriberBilletMenuAuthorizationResource
     */
    public function menu(IndexSubscriberBilletAuthorizationRequest $request): SubscriberBilletMenuAuthorizationResource
    {
        $subscriberBilletAuthorization = $this->subscriberBilletAuthorizationService->menu($request);

        return new SubscriberBilletMenuAuthorizationResource($subscriberBilletAuthorization, __('messages.' . self::class . '.MENU.INDEX'));
    }

    /**
     * @param IndexSubscriberBilletAuthorizationRequest  $request
     *
     * @return SubscriberBilletAuthorizationCollection
     */
    public function page(IndexSubscriberBilletAuthorizationRequest $request): SubscriberBilletAuthorizationCollection
    {
        $subscriberBilletAuthorization = $this->subscriberBilletAuthorizationService->page($request);

        return new SubscriberBilletAuthorizationCollection($subscriberBilletAuthorization, __('messages.' . self::class . '.PAGE.INDEX'));
    }
}
