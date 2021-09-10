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
    const intro        = 0;
    const contributionCommissie = 1;
    const contribution = 2;
    const activity = 3;
}
