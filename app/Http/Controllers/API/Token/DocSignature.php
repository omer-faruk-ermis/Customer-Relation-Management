<?php

namespace App\Http\Controllers\API\Token;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Services\Token\DocSignatureService;
use Illuminate\Http\Request;

/**
 * Class DocSignature
 *
 * @package App\Http\Controllers\API\Token
 */
class DocSignature extends Controller
{
    /** @var DocSignatureService $docSignatureService */
    private DocSignatureService $docSignatureService;

    /**
     * DocSignature constructor
     */
    public function __construct()
    {
        $this->docSignatureService = new DocSignatureService();
    }

    /**
     * @param Request $request
     *
     * @return TokenResource
     */
    public function getSignatureToken(Request $request): TokenResource
    {
        $docSignatureToken = $this->docSignatureService->getSignatureToken($request);

        return new TokenResource((object) $docSignatureToken, 'DOC_SIGNATURE.SUCCESS');
    }
}
