<?php

namespace SupportUsBundle\Lib;

class Corporate
{
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
                $amountLocalized = $amount * 1.5;
                break;
            case 'CAD':
                $amountLocalized = $amount * 1.5;
                break;
            case 'GBP':
                $amountLocalized = $amount * 0.9;
                break;
            case 'JPY':
                $amountLocalized = $amount * 130;
                break;
            case 'USD':
                $amountLocalized = $amount * 1.2;
                break;
            default:
                $amountLocalized = $amount;
                break;
        }

        return $amountLocalized;
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
