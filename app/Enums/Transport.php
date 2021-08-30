<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Transport extends Enum
{
    const camping = 0;
    const bus = 1;
    const own_transport = 2;

    public static function getDescription($value): string
    {
        if ($value === self::camping) {
            return 'Camping';
        }
        if ($value === self::bus) {
            return 'Bus';
        }
        if ($value === self::own_transport) {
            return 'Eigen vervoer';
        }

        return parent::getDescription($value);
    }
}
