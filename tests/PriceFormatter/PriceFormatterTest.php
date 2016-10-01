<?php

namespace Bws\PriceFormatter;

class PriceFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param double $price
     * @param string $expected
     */
    protected function assertPriceFormatted($price, $expected)
    {
        $this->assertSame($expected, PriceFormatter::format($price));
    }

    public function testFormat()
    {
        $this->assertPriceFormatted(null, '0.00');
        $this->assertPriceFormatted(0, '0.00');
        $this->assertPriceFormatted(1, '1.00');
        $this->assertPriceFormatted(1.25, '1.25');
        $this->assertPriceFormatted(1.2, '1.20');
        $this->assertPriceFormatted('1.2', '1.20');
    }
}
