<?php

namespace App\Http\Requests;

use App\Utils\Security;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Abstract class AbstractRequest
 *
 * @package App\Http\Resources
 */
abstract class AbstractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    protected $fieldsToDecrypt = [];

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        foreach ($this->fieldsToDecrypt as $field) {
            if ($this->has($field)) {
                $this->merge([
                                 $field => Security::decrypt($this->input($field))
                             ]);
            }
        }
    }

    /**
     * @param Validator  $validator
     *
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
