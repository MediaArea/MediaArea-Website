<?php

namespace SupportUsBundle\Tests\Lib;

use SupportUsBundle\Lib\Individual;
use PHPUnit\Framework\TestCase;

class IndividualTest extends TestCase
{
    public function testAmountToVotes()
    {
        $individual = new Individual();

        if (date('Ymd') <= '20171231') {
            $this->assertEquals(23, $individual->amountToVotes(30, 'EUR'));
            $this->assertEquals(23, $individual->amountToVotes(36, 'AUD'));
            $this->assertEquals(23, $individual->amountToVotes(36, 'CAD'));
            $this->assertEquals(23, $individual->amountToVotes(30, 'GBP'));
            $this->assertEquals(23, $individual->amountToVotes(3000, 'JPY'));
            $this->assertEquals(23, $individual->amountToVotes(30, 'USD'));
            $this->assertEquals(0, $individual->amountToVotes(20, 'EUR'));
            $this->assertEquals(0, $individual->amountToVotes(30, 'AUD'));
        } else {
            $this->assertEquals(15, $individual->amountToVotes(30, 'EUR'));
            $this->assertEquals(15, $individual->amountToVotes(36, 'AUD'));
            $this->assertEquals(15, $individual->amountToVotes(36, 'CAD'));
            $this->assertEquals(15, $individual->amountToVotes(30, 'GBP'));
            $this->assertEquals(15, $individual->amountToVotes(3000, 'JPY'));
            $this->assertEquals(15, $individual->amountToVotes(30, 'USD'));
            $this->assertEquals(0, $individual->amountToVotes(20, 'EUR'));
            $this->assertEquals(0, $individual->amountToVotes(30, 'AUD'));
        }
    }

    public function testAmountToMembership()
    {
        $individual = new Individual();

        if (date('Ymd') <= '20171231') {
            $this->assertEquals(new \DateTime('2020-01-01'), $individual->amountToMembership(10, 'EUR'));
            $this->assertEquals(new \DateTime('2021-01-01'), $individual->amountToMembership(15, 'EUR'));
            $this->assertEquals(new \DateTime('2022-01-01'), $individual->amountToMembership(20, 'EUR'));
            $this->assertEquals(new \DateTime('2022-01-01'), $individual->amountToMembership(50, 'EUR'));
            $date = new \DateTime(date('Y-m-d'));
            $this->assertEquals($date->sub(new \DateInterval('P1D')), $individual->amountToMembership(5, 'EUR'));
        } else {
            $date = new \DateTime(date('Y-m-d'));
            $this->assertEquals($date->add(new \DateInterval('P1Y1D')), $individual->amountToMembership(10, 'EUR'));
            $date = new \DateTime(date('Y-m-d'));
            $this->assertEquals($date->add(new \DateInterval('P2Y1D')), $individual->amountToMembership(15, 'EUR'));
            $date = new \DateTime(date('Y-m-d'));
            $this->assertEquals($date->add(new \DateInterval('P3Y1D')), $individual->amountToMembership(20, 'EUR'));
            $this->assertEquals($date, $individual->amountToMembership(50, 'EUR'));
            $date = new \DateTime(date('Y-m-d'));
            $this->assertEquals($date->sub(new \DateInterval('P1D')), $individual->amountToMembership(5, 'EUR'));
        }
    }

    public function testGetLocalizedAmountWithCurrency()
    {
        $individual = new Individual();

        $this->assertEquals('10 €', $individual->getLocalizedAmountWithCurrency(10, 'EUR'));
        $this->assertEquals('$1', $individual->getLocalizedAmountWithCurrency(1, 'AUD'));
        $this->assertEquals('$12', $individual->getLocalizedAmountWithCurrency(10, 'AUD'));
        $this->assertEquals('$2', $individual->getLocalizedAmountWithCurrency(2, 'CAD'));
        $this->assertEquals('$12', $individual->getLocalizedAmountWithCurrency(10, 'CAD'));
        $this->assertEquals('10 £', $individual->getLocalizedAmountWithCurrency(10, 'GBP'));
        $this->assertEquals('1000 ¥', $individual->getLocalizedAmountWithCurrency(10, 'JPY'));
        $this->assertEquals('$10', $individual->getLocalizedAmountWithCurrency(10, 'USD'));
    }
}
