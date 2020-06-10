<?php

namespace WaseemAkhtarr\PaymentDatesSDK\Exceptions;

use Throwable;

/**
 * @method InvalidMonthException withException(Throwable $throwable)
 */
class InvalidMonthException extends PaymentDatesException
{
    public const MESSAGE = 'Invalid Month (%d)';
    public const CODE = 1000;
}
