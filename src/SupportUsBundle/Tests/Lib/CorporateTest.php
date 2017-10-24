<?php

namespace SupportUsBundle\Tests\Lib;

use SupportUsBundle\Lib\Corporate;
use PHPUnit\Framework\TestCase;

class CorporateTest extends TestCase
{
    public function testGetLocalizedAmountWithCurrency()
    {
        $corporate = new Corporate();

        $this->assertEquals('1000 €', $corporate->getLocalizedAmountWithCurrency(1000, 'EUR'));
        $this->assertEquals('$1500', $corporate->getLocalizedAmountWithCurrency(1000, 'AUD'));
        $this->assertEquals('$1500', $corporate->getLocalizedAmountWithCurrency(1000, 'CAD'));
        $this->assertEquals('900 £', $corporate->getLocalizedAmountWithCurrency(1000, 'GBP'));
        $this->assertEquals('130000 ¥', $corporate->getLocalizedAmountWithCurrency(1000, 'JPY'));
        $this->assertEquals('$1200', $corporate->getLocalizedAmountWithCurrency(1000, 'USD'));
    }
}
