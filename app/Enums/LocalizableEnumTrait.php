<?php

namespace App\Enums;

use App\Traits\LocalizableTrait;

trait LocalizableEnumTrait
{
    use LocalizableTrait;

    private const BASE_NAMESPACE = 'App\\Enums';
    private const TRANSLATION_PATH = 'enums';
    private const DESCRIPTION_FILE_SUFFIX = 'Description.';

    /**
     * Gets the label of the enum.
     *
     * @return string|null
     */
    public function label(): ?string
    {
        return $this->getTranslation($this->value);
    }

    /**
     * Gets the description of the enum.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->getTranslation('CallDirection');
    }

    /**
     * Gets the value of the enum.
     *
     * @return string|null
     */
    public function value(): ?string
    {
        return $this->getTranslation($this->value);
    }
}
