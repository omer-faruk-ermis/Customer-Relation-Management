<?php

namespace App\Helpers;

use App\Exceptions\Code\InvalidSecurityCodeException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CodeValidate
{
    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public static function handle(Request $request): void
    {
        $imagePath = $request->input('security_code_path');
        $imageCode = $request->input('security_code');

        if (empty($imageCode) || empty($imagePath)) {
            throw new InvalidSecurityCodeException();
        }

        if (!(Cache::get('security_code_' . $imagePath) === $imageCode)) {
            throw new InvalidSecurityCodeException();
        }
    }
}
