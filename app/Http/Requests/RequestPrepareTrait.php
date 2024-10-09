<?php

namespace App\Http\Requests;

use App\Utils\Security;
use Illuminate\Validation\Rule;

trait RequestPrepareTrait
{
    /**
     * @return void
     */
    protected function removeInvalidCharacters(): void
    {
        foreach ($this->all() as $field => $value) {
            if ($this->hasInvalidCharacters($value)) {
                $this->request->remove($field);
            }
        }
    }

    /**
     * @param $value
     *
     * @return bool
     */
    protected function hasInvalidCharacters($value): bool
    {
        return is_string($value) && substr_count($value, '*') >= 3 || in_array($value, ['*', '**']);
    }

    /**
     * @return void
     */
    protected function decryptFields(): void
    {
        foreach ($this->fieldsToDecrypt as $fieldName => $fields) {
            if ($this->has($fieldName)) {
                $data = collect($this->input($fieldName))
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
            } elseif ($this->has($fields)) {
                $this->merge([$fields => Security::decrypt($this->input($fields))]);
            }
        }
    }

    /**
     * @return array
     */
    protected function getEncryptRules(): array
    {
        return [
            Rule::notIn(['*', '**']),
            fn($attribute, $value, $fail) => is_string($value) && substr_count($value, '*') >= 3
                && $fail(__('validation.encrpyt_fields', ['attribute' => $attribute])),
        ];
    }
}
