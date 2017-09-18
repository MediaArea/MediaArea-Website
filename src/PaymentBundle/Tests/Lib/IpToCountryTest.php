<?php

namespace PaymentBundle\Tests\Lib;

use PaymentBundle\Lib\IpToCountry;
use PHPUnit\Framework\TestCase;

class IpToCountryTest extends TestCase
{
    public function testWithoutIp()
    {
        $ipToCountry = new IpToCountry();

        $this->assertEquals('XX', $ipToCountry->getCountryIsoCode());
        $this->assertEquals('XX', $ipToCountry->getCountryName());
    }

    public function testWithUSIp()
    {
        $ipToCountry = new IpToCountry('8.8.8.8');

        $this->assertEquals('US', $ipToCountry->getCountryIsoCode());
        $this->assertEquals('United States', $ipToCountry->getCountryName());
    }

    public function testWithUnknownIp()
    {
        $ipToCountry = new IpToCountry('127.0.0.1');

        $this->assertEquals('XX', $ipToCountry->getCountryIsoCode());
        $this->assertEquals('XX', $ipToCountry->getCountryName());
    }
}
