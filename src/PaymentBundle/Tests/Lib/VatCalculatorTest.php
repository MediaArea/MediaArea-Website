<?php

namespace PaymentBundle\Tests\Lib;

use PaymentBundle\Lib\VatCalculator;
use PHPUnit\Framework\TestCase;

class VatCalculatorTest extends TestCase
{
    public function testCalculateNetUECountry()
    {
        $vat = new VatCalculator();
        $vat->setGross(12)
            ->setCountry('FR')
            ->calculateNet();

        $this->assertEquals(10, $vat->getNet());
        $this->assertEquals(2, $vat->getVatAmount());
        $this->assertEquals(12, $vat->getGross());
        $this->assertEquals(20, $vat->getVatRate());

        $vat->setGross(10)
            ->setCountry('FR')
            ->calculateNet();

        $this->assertEquals(8.33, $vat->getNet());
        $this->assertEquals(1.67, $vat->getVatAmount());
        $this->assertEquals(10, $vat->getGross());
        $this->assertEquals(20, $vat->getVatRate());

        $vat->setGross(1)
            ->setCountry('LU')
            ->calculateNet();

        $this->assertEquals(0.85, $vat->getNet());
        $this->assertEquals(0.15, $vat->getVatAmount());
        $this->assertEquals(1, $vat->getGross());
        $this->assertEquals(17, $vat->getVatRate());
    }

    public function testCalculateNetNonUECountry()
    {
        $vat = new VatCalculator();
        $vat->setGross(12)
            ->setCountry('US')
            ->calculateNet();

        $this->assertEquals(12, $vat->getNet());
        $this->assertEquals(0, $vat->getVatAmount());
        $this->assertEquals(12, $vat->getGross());
        $this->assertEquals(0, $vat->getVatRate());
    }

    public function testCalculateNetUnknownCountry()
    {
        $vat = new VatCalculator();
        $vat->setGross(12)
            ->setCountry('XX')
            ->calculateNet();

        $this->assertEquals(12, $vat->getNet());
        $this->assertEquals(0, $vat->getVatAmount());
        $this->assertEquals(12, $vat->getGross());
        $this->assertEquals(0, $vat->getVatRate());
    }
}
