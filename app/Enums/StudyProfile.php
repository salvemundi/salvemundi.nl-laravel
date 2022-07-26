<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StudyProfile extends Enum
{
    const None = 0;
    const Software = 1;
    const Technology = 2;
    const Infra = 3;
    const Business = 4;
    const Media = 5;
    const Diverse = 6;

    public static function getDescription($value): string
    {
        if ($value === self::None) {
            return 'N.v.t.';
        }
        if ($value === self::Software) {
            return 'Software';
        }
        if ($value === self::Technology) {
            return 'Technology';
        }
        if ($value === self::Infra) {
            return 'Infra';
        }
        if ($value === self::Business) {
            return 'Business';
        }
        if ($value === self::Media) {
            return 'Media';
        }
        if ($value === self::Diverse){
            return "Diverse";
        }

        return parent::getDescription($value);
    }
}
