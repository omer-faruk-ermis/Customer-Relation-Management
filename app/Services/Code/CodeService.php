<?php

namespace App\Services\Code;

use App\Helpers\CodeGenerator;
use Illuminate\Support\Facades\Storage;

/**
 * Class CodeService
 *
 * @package App\Service\Code
 */
class CodeService
{
    /**
     * @return object
     */
    public function securityCode(): object
    {
        $image_path = CodeGenerator::generateSecurityCodeImage();
        $image = Storage::get('public/' . $image_path);

        return (object) [
            'image_path'    => $image_path,
            'image_content' => base64_encode($image),
            'content_type'  => 'image/png'
        ];
    }
}
