<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use Illuminate\Http\Request;

/**
 * Abstract class AbstractService
 *
 * @package App\Services
 */
abstract class AbstractService
{
    protected array $serviceAuthorizations = [];
    protected array $privateMethods = [];
    protected array $publicMethods = [];

    /**
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        new PermissionService(
            $request,
            $this->serviceAuthorizations,
            $this->privateMethods,
            $this->publicMethods
        );
    }
}
