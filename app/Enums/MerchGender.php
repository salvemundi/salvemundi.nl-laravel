<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static unisex()
 * @method static static male()
 * @method static static female()
 */
final class MerchGender extends Enum
{
    const unisex = 0;
    const male = 1;
    const female = 2;

    public static function getDescription($value): string
    {
        if ($value === self::unisex) {
            return 'Unisex';
        }
        if ($value === self::male) {
            return 'Male';
        }
        if ($value === self::female) {
            return 'Female';
        }
        return parent::getDescription($value);
    }
}
