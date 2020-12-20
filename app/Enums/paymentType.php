<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static default()
 * @method static static intro()
 * @method static static inschrijving()
 */
final class paymentType extends Enum
{
    const default      = 0;
    const intro        = 1;
    const inschrijving = 2;
}
