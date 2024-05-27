<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginVerificationRequest;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\TokenResource;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\API\Auth
 */
class AuthController extends Controller
{
    /** @var AuthService $authService */
    private AuthService $authService;

    /**
     * AuthController constructor
     */
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * @param LoginRequest $request
     * @return TokenResource
     * @throws Exception
     */
    public function login(LoginRequest $request): TokenResource
    {
        $token = $this->authService->login($request);

        return new TokenResource((object) $token, 'AUTH.LOGIN.SUCCESS');
    }

    /**
     * @param LoginVerificationRequest  $request
     *
     * @return EmployeeResource
     * @throws Exception
     */
    public function loginVerification(LoginVerificationRequest $request): EmployeeResource
    {
        $smsKimlik = $this->authService->loginVerification($request);

        return new EmployeeResource($smsKimlik, 'AUTH.LOGIN_VERIFICATION.EMPLOYEE.SUCCESS');
    }

    /**
     * @param ForgotPasswordRequest  $request
     *
     * @return TokenResource
     * @throws Exception
     */
    public function forgotPassword(ForgotPasswordRequest $request): TokenResource
    {
        $token = $this->authService->forgotPassword($request);

        return new TokenResource((object) $token, 'AUTH.FORGOT_PASSWORD.SUCCESS');
    }

    /**
     * @param NewPasswordRequest $request
     * @return SuccessResource
     * @throws Exception
     */
    public function newPassword(NewPasswordRequest $request): SuccessResource
    {
        $this->authService->newPassword($request);

        return new SuccessResource('AUTH.NEW_PASSWORD.SUCCESS');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return SuccessResource
     * @throws Exception
     */
    public function changePassword(ChangePasswordRequest $request): SuccessResource
    {
        $this->authService->changePassword($request);

        return new SuccessResource('AUTH.CHANGE_PASSWORD.SUCCESS');
    }

    /**
     * @param Request  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function logout(Request $request): SuccessResource
    {
        $this->authService->logout($request);

        return new SuccessResource('AUTH.LOGOUT.SUCCESS');
    }
}
