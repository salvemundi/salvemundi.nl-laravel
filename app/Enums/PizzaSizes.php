<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PizzaSizes extends Enum
{
    const Medium = 0;
    const Italian = 1;
    const Large = 2;
    const FamilyXXL = 3;

    public static function getDescription($value): string
    {
        if ($value === self::Medium) {
            return 'Medium';
        }
        if ($value === self::Italian) {
            return 'Italian';
        }
        if ($value === self::Large) {
            return 'Large';
        }
        if ($value === self::FamilyXXL) {
            return 'Family XXL';
        }

        return parent::getDescription($value);
    }
}
