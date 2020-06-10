<?php

namespace WaseemAkhtarr\PaymentDatesSDK;

use Exception;
use Throwable;

abstract class PaymentSDKException extends Exception
{
    public const MESSAGE = '';
    public const CODE = 0;

    /**
     * BankAccountLookUpException constructor.
     *
     * @param mixed ...$args
     */
    public function __construct(...$args)
    {
        parent::__construct(sprintf(static::MESSAGE, ...$args), static::CODE);
    }

    /**
     * @param Throwable $throwable
     * @return $this
     */
    public function withException(Throwable $throwable)
    {
        parent::__construct($this->getMessage(), $this->getCode(), $throwable);

        return $this;
    }
}
