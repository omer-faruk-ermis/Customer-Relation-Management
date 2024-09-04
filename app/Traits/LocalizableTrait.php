<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;
use ReflectionClass;

trait LocalizableTrait
{
    /**
     * Gets the localized translation of a given key.
     *
     * @param string $key          The translation key within the file.
     * @param array  $replacements An array of replacements for translation placeholders.
     *
     * @return string|null The localized string or null if not found.
     */
    protected static function getTranslation(string $key, array $replacements = []): ?string
    {
        $localizedStringKey = static::getLocalizationKey() . '.' . $key;
        if (Lang::has($localizedStringKey)) {
            return __($localizedStringKey, $replacements);
        }

        return null;
    }

    /**
     * Constructs the base localization key for the enum class.
     *
     * @return string The constructed localization key.
     */
    private static function getLocalizationKey(): string
    {
        return 'enums/' . (new ReflectionClass(static::class))->getShortName();
    }
}
