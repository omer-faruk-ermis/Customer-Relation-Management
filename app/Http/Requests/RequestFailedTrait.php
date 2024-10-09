<?php

namespace App\Http\Requests;

trait RequestFailedTrait
{
    /**
     * @param array  $errors
     *
     * @return array
     */
    private function formatErrors(array $errors): array
    {
        return collect($errors)->flatMap(function ($messages, $field) {
            return collect($messages)->map(fn($message) => [
                'field' => $field,
                'message' => $this->translateMessage($field, $message),
            ]);
        })->toArray();
    }

    /**
     * @param string  $field
     * @param string  $message
     *
     * @return string
     */
    private function translateMessage(string $field, string $message): string
    {
        $attributeName = __("validation.attributes.{$field}");
        $translations = [
            'required' => 'validation.required',
            'boolean' => 'validation.boolean',
        ];

        foreach ($translations as $keyword => $translation) {
            if (str_contains($message, $keyword)) {
                return __($translation, ['attribute' => $attributeName]);
            }
        }

        return $message;
    }
}
