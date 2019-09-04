<?php
declare(strict_types=1);

namespace TildBJ\Abo\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility as Typo3LocalizationUtility;

/**
 * Class LocalizationUtility
 */
class LocalizationUtility
{
    /**
     * @param string $key
     * @return string|null
     */
    public static function translate(string $key)
    {
        if (!$translation = Typo3LocalizationUtility::translate($key, 'Abo')) {
            return '[' . $key . ']';
        }

        return $translation;
    }
}
