<?php

namespace App\Helpers;

use App\Enums\DefaultConstant;
use App\Enums\RegexPattern;
use App\Exceptions\Auth\AgainPasswordException;
use App\Exceptions\Auth\InvalidPasswordFormatException;
use App\Exceptions\Auth\PasswordLengthException;
use Exception;
use Illuminate\Http\Request;

class PasswordValidate
{
    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public static function handle(Request $request): void
    {
        $newPassword = $request->input('new_password');
        $newPasswordAgain = $request->input('new_password_again');

        if (strlen($newPassword) < DefaultConstant::MIN_PASSWORD_LENGTH || strlen($newPasswordAgain) < DefaultConstant::MIN_PASSWORD_LENGTH) {
            throw new PasswordLengthException();
        }

        if (!preg_match(RegexPattern::PASSWORD, $newPassword) || !preg_match(RegexPattern::PASSWORD, $newPasswordAgain)) {
            throw new InvalidPasswordFormatException();
        }

        if ($newPassword !== $newPasswordAgain) {
            throw new AgainPasswordException();
        }
    }
}
