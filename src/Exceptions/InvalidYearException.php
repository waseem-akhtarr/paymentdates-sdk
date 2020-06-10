<?php

namespace WaseemAkhtarr\PaymentDatesSDK\Exceptions;

use Throwable;

/**
 * @method InvalidYearException withException(Throwable $throwable)
 */
class InvalidYearException extends PaymentDatesException
{
    public const MESSAGE = 'Invalid Year (%d)';
    public const CODE = 1001;
}
