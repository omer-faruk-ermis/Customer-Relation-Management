<?php

namespace App\Http\Controllers\API\Code;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Services\Code\CodeService;

/**
 * Class CodeController
 *
 * @package App\Http\Controllers\API\Code
 */
class CodeController extends Controller
{
    /** @var CodeService $codeService */
    private CodeService $codeService;

    /**
     * CodeController constructor
     */
    public function __construct()
    {
        $this->codeService = new CodeService();
    }
    /**
     * @return ImageResource
     */
    public function securityCode(): ImageResource
    {
        $image = $this->codeService->securityCode();

        return new ImageResource($image, __('messages.' . self::class . '.CREATE'));
    }
}
