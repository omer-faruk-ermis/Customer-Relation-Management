<?php

namespace App\Http\Requests;

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
    use RequestPrepareTrait, RequestFailedTrait;

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
        $this->removeInvalidCharacters();
        $this->decryptFields();
    }

    /**
     * @param Validator  $validator
     *
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $detailedErrors = $this->formatErrors($validator->errors()->toArray());

        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'message' => 'Validation error',
                    'errors'  => $detailedErrors,
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
