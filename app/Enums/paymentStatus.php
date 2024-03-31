<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static unPaid()
 * @method static static paid()
 * @method static static open()
 * @method static static failed()
 * @method static static canceled()
 * @method static static expired()
 * @method static static pending()
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

    // Mollie compatability
    const isCanceled = 4;
    const isFailed = 3;
    const isExpired = 5;
    const isPending = 6;
    const isOpen = 2;
    const isPaid = 1;
}
