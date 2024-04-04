<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static generic()
 * @method static static shoe()
 */
final class MerchType extends Enum
{
    const generic = 0;
    const shoe = 1;

    public static function getDescription($value): string
    {
        if ($value === self::generic) {
            return 'Generiek';
        }
        if ($value === self::shoe) {
            return 'Schoen';
        }

        return parent::getDescription($value);
    }

}
