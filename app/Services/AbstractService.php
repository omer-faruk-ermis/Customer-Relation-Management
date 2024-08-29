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
    protected array $privateMethods = [];
    protected array $publicMethods = [];
    protected Request $request;

    /**
     * @throws ForbiddenException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        new PermissionService(
            $request,
            class_basename($this),
            $this->privateMethods,
            $this->publicMethods
        );
    }
}
