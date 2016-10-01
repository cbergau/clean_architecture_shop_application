<?php

namespace Bws\PriceFormatter;

class PriceFormatter
{
    /**
     * @param double $price
     *
     * @return string
     */
    public static function format($price)
    {
        return number_format($price, 2);
    }
}
