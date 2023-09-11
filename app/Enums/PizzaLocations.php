<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PizzaLocations extends Enum
{
    const R10 = 0;
    const TQ = 1;

    public static function getDescription($value): string
    {
        if ($value === self::R10) {
            return 'Rachelsmolen R10';
        }
        if ($value === self::TQ) {
            return 'Strijp TQ';
        }

        return parent::getDescription($value);
    }
}
