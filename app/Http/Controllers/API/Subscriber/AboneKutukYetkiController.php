<?php

namespace App\Http\Controllers\API\Subscriber;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\IndexSubscriberBilletAuthorizationRequest;
use App\Http\Resources\Subscriber\SubscriberBilletAuthorizationCollection;
use App\Services\Authorization\SubscriberBilletAuthorizationService;

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
     */
    public function __construct()
    {
        $this->subscriberBilletAuthorizationService = new SubscriberBilletAuthorizationService();
    }

    /**
     * @param IndexSubscriberBilletAuthorizationRequest  $request
     *
     * @return SubscriberBilletAuthorizationCollection
     */
    public function index(IndexSubscriberBilletAuthorizationRequest $request): SubscriberBilletAuthorizationCollection
    {
        $subscriberBilletAuthorization = $this->subscriberBilletAuthorizationService->index($request);

        return new SubscriberBilletAuthorizationCollection($subscriberBilletAuthorization, 'SUBSCRIBER_BILLET_AUTHORIZATION.INDEX.SUCCESS');
    }
}
