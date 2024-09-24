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
        foreach ($this->fieldsToDecrypt as $fieldName => $fields) {
            if ($this->has($fieldName)) {
                $data =
                    collect($this->input($fieldName))
                        ->map(function ($item) use ($fields) {
                            foreach ($fields as $field) {
                                if (isset($item[$field])) {
                                    $item[$field] = Security::decrypt($item[$field]);
                                }
                            }
                            return $item;
                        })
                        ->toArray();

                $this->merge([$fieldName => $data]);
            } else {
                if ($this->has($fields)) {
                    $this->merge([
                                     $fields => Security::decrypt($this->input($fields))
                                 ]);
                }
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
        $errors = $validator->errors()->toArray();

        $detailedErrors = [];
        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                $attributeName = __(sprintf('validation.attributes.%s', $field));
                if (str_contains($message, 'required')) {
                    $translatedMessage = __('validation.required', ['attribute' => $attributeName]);
                } elseif (str_contains($message, 'boolean')) {
                    $translatedMessage = __('validation.boolean', ['attribute' => $attributeName]);
                } else {
                    $translatedMessage = $message;
                }

                $detailedErrors[] = [
                    'field'   => $field,
                    'message' => $translatedMessage,
                ];
            }
        }

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
