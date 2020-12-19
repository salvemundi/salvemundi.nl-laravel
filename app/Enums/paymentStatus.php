<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class paymentStatus extends Enum
{
    const unPaid = 0;
    const paid = 1;
    const open = 2;
    const failed = 3;
    const canceled = 4;
    const expired = 5;
    const pending = 6;
}
