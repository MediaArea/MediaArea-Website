<?php

namespace PaymentBundle\Tests\Lib;

use PaymentBundle\Lib\IpToCurrency;
use PHPUnit\Framework\TestCase;

class IpToCurrencyTest extends TestCase
{
    public function testWithoutIp()
    {
        $ipToCurrency = new IpToCurrency();

        $this->assertEquals('EUR', $ipToCurrency->getCurrency());
        $this->assertEquals('10', $ipToCurrency->getAmountDefault());
        $this->assertTrue(is_array($ipToCurrency->getAmountChoices()) && 1 <= count($ipToCurrency->getAmountChoices()));
    }

    public function testWithUSIp()
    {
        $ipToCurrency = new IpToCurrency('8.8.8.8');

        $this->assertEquals('USD', $ipToCurrency->getCurrency());
        $this->assertEquals('10', $ipToCurrency->getAmountDefault());
        $this->assertTrue(is_array($ipToCurrency->getAmountChoices()) && 1 <= count($ipToCurrency->getAmountChoices()));
    }

    public function testWithUnknownIp()
    {
        $ipToCurrency = new IpToCurrency('127.0.0.1');

        $this->assertEquals('EUR', $ipToCurrency->getCurrency());
        $this->assertEquals('10', $ipToCurrency->getAmountDefault());
        $this->assertTrue(is_array($ipToCurrency->getAmountChoices()) && 1 <= count($ipToCurrency->getAmountChoices()));
    }
}
