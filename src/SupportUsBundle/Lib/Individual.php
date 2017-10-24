<?php

namespace SupportUsBundle\Lib;

class Individual
{
    protected $earlyBird = '20171231';

    /**
     * Get number of voting points.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return int
     */
    public function amountToVotes($amount, $currency)
    {
        $amount = $this->getNormalizedAmount($amount, $currency);

        // Votes only for >= 30€
        if (30 <= $amount) {
            // Early bird: votes x 1.5
            if ($this->earlyBird >= date('Ymd')) {
                return (int) round($amount / 10 * 5 * 1.5);
            }

            return (int) round($amount / 10 * 5);
        }

        return 0;
    }

    /**
     * Get membership end date.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return DateTime
     */
    public function amountToMembership($amount, $currency)
    {
        $amount = $this->getNormalizedAmount($amount, $currency);

        // Membership only for >= 10€
        if (20 <= $amount) {
            // Early bird
            if ($this->earlyBird >= date('Ymd')) {
                return new \DateTime('2022-01-01');
            }

            // 3 years for 20€
            $date = new \DateTime(date('Y-m-d'));

            return $date->add(new \DateInterval('P3Y1D'));
        } elseif (15 <= $amount) {
            // Early bird
            if ($this->earlyBird >= date('Ymd')) {
                return new \DateTime('2021-01-01');
            }

            // 2 years for 15€
            $date = new \DateTime(date('Y-m-d'));

            return $date->add(new \DateInterval('P2Y1D'));
        } elseif (10 <= $amount) {
            // Early bird
            if ($this->earlyBird >= date('Ymd')) {
                return new \DateTime('2020-01-01');
            }

            // 1 year for 10€
            $date = new \DateTime(date('Y-m-d'));

            return $date->add(new \DateInterval('P1Y1D'));
        }

        $date = new \DateTime(date('Y-m-d'));

        return $date->sub(new \DateInterval('P1D'));
    }

    /**
     * Get amount with currency symbol and currency exchange.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return int|float
     */
    public function getLocalizedAmountWithCurrency($amount, $currency)
    {
        return $this->getAmountWithCurrency($this->getLocalizedAmount($amount, $currency), $currency);
    }

    /**
     * Normalize amount to Euros.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return int|float
     */
    protected function getNormalizedAmount($amount, $currency)
    {
        switch ($currency) {
            case 'AUD':
                $amountNormalized = $amount / 1.2;
                break;
            case 'CAD':
                $amountNormalized = $amount / 1.2;
                break;
            case 'GBP':
                $amountNormalized = $amount / 1;
                break;
            case 'JPY':
                $amountNormalized = $amount / 100;
                break;
            case 'USD':
                $amountNormalized = $amount / 1;
                break;
            default:
                $amountNormalized = $amount;
                break;
        }

        return round($amountNormalized);
    }

    /**
     * Get amount with currency exchange.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return int|float
     */
    protected function getLocalizedAmount($amount, $currency)
    {
        switch ($currency) {
            case 'AUD':
                $amountLocalized = $amount * 1.2;
                break;
            case 'CAD':
                $amountLocalized = $amount * 1.2;
                break;
            case 'GBP':
                $amountLocalized = $amount * 1;
                break;
            case 'JPY':
                $amountLocalized = $amount * 100;
                break;
            case 'USD':
                $amountLocalized = $amount * 1;
                break;
            default:
                $amountLocalized = $amount;
                break;
        }

        return round($amountLocalized);
    }

    /**
     * Get amount with currency symbol.
     *
     * @param int|float $amount
     * @param string    $currency
     *
     * @return string
     */
    protected function getAmountWithCurrency($amount, $currency)
    {
        switch ($currency) {
            case 'AUD':
                $amountWithCurrency = '$'.$amount;
                break;
            case 'CAD':
                $amountWithCurrency = '$'.$amount;
                break;
            case 'GBP':
                $amountWithCurrency = $amount.' £';
                break;
            case 'JPY':
                $amountWithCurrency = $amount.' ¥';
                break;
            case 'USD':
                $amountWithCurrency = '$'.$amount;
                break;
            default:
                $amountWithCurrency = $amount.' €';
                break;
        }

        return $amountWithCurrency;
    }
}
