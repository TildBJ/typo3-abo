<?php
declare(strict_types=1);

namespace TildBJ\Abo\Utility;

/**
 * Class GeneralUtility
 */
class GeneralUtility
{
    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomString(int $length = 16): string
    {
        $str = '';
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
