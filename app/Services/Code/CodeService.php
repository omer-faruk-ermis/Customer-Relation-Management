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
     * @return array
     */
    public function securityCode(): array
    {
        $image_path = CodeGenerator::generateSecurityCodeImage();
        $image = Storage::get('public/' . $image_path);

        return [
            'image_path'    => $image_path,
            'image_content' => base64_encode($image),
            'content_type'  => 'image/png'
        ];
    }
}
