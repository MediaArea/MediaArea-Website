<?php

namespace PaymentBundle\Lib;

class IpToCurrency
{
    /**
     * Country of user.
     *
     * @var string
     */
    protected $country;

    /**
     * Data per country.
     *
     * @var array
     */
    protected $data = [
        'AU' => [
            'currency' => 'AUD',
            'currencySymbol' => 'AU$',
            'currencySymbolDisposition' => 'left',
            'amountChoices' => [1, 2, 5, 10, 25, 50, 100, 200, 500],
            'amountDefault' => '10',
        ],
        'CA' => [
            'currency' => 'CAD',
            'currencySymbol' => 'CA$',
            'currencySymbolDisposition' => 'left',
            'amountChoices' => [1, 2, 5, 10, 25, 50, 100, 200, 500],
            'amountDefault' => '10',
        ],
        'GB' => [
            'currency' => 'GBP',
            'currencySymbol' => '£',
            'currencySymbolDisposition' => 'left',
            'amountChoices' => [1, 2, 5, 10, 25, 50, 100, 200, 500],
            'amountDefault' => '10',
        ],
        'JA' => [
            'currency' => 'JPY',
            'currencySymbol' => '¥',
            'currencySymbolDisposition' => 'right',
            'amountChoices' => [100, 200, 500, 1000, 2500, 5000, 10000, 20000, 50000],
            'amountDefault' => '10',
        ],
        'US' => [
            'currency' => 'USD',
            'currencySymbol' => 'US$',
            'currencySymbolDisposition' => 'left',
            'amountChoices' => [1, 2, 5, 10, 25, 50, 100, 200, 500],
            'amountDefault' => '10',
        ],
    ];

    /**
     * Default data.
     *
     * @var array
     */
    protected $defaultData = [
        'currency' => 'EUR',
        'currencySymbol' => '€',
        'currencySymbolDisposition' => 'right',
        'amountChoices' => [1, 2, 5, 10, 25, 50, 100, 200, 500],
        'amountDefault' => '10',
    ];

    /**
     * Constructor.
     *
     * @param string $ip IP address of user
     */
    public function __construct($ip = '127.0.0.1')
    {
        $this->getCountry($ip);
    }

    /**
     * Get country from IP address.
     *
     * @param string $ip IP address of user
     *
     * @return IpToCurrency
     */
    protected function getCountry($ip)
    {
        $ipToCountry = new IpToCountry($ip);
        $this->country = $ipToCountry->getCountryIsoCode('FR');

        return $this;
    }

    /**
     * Get the currency of the user country.
     *
     * @return string Currency
     */
    public function getCurrency()
    {
        return $this->data[$this->country]['currency'] ?? $this->defaultData['currency'];
    }

    /**
     * Get the currency symbol of the user country.
     *
     * @return string Currency
     */
    public function getCurrencySymbol()
    {
        return $this->data[$this->country]['currencySymbol'] ?? $this->defaultData['currencySymbol'];
    }

    /**
     * Get the currency symbol disposition of the user country.
     *
     * @return string Currency
     */
    public function getCurrencySymbolDisposition()
    {
        return $this->data[$this->country]['currencySymbolDisposition'] ??
            $this->defaultData['currencySymbolDisposition'];
    }

    /**
     * Get the amount choices for form select list.
     *
     * @return array Amount choices
     */
    public function getAmountChoices()
    {
        $amount = $this->data[$this->country]['amountChoices'] ?? $this->defaultData['amountChoices'];
        $amountChoices = array_combine($amount, $amount);
        array_walk($amountChoices, array($this, 'amountChoicesWithCurrency'));

        return array_flip($amountChoices);
    }

    /**
     * Get the default amount for form select list.
     *
     * @return int Default amount
     */
    public function getAmountDefault()
    {
        return $this->data[$this->country]['amountDefault'] ?? $this->defaultData['amountDefault'];
    }

    /**
     * Get the amount with the currency symbol.
     *
     * @param int|float $amount
     *
     * @return string
     */
    public function amountWithCurrency($amount)
    {
        if ('left' == $this->getCurrencySymbolDisposition()) {
            return $this->getCurrencySymbol().$amount;
        } else {
            return $amount.' '.$this->getCurrencySymbol();
        }
    }

    /**
     * Get the amount with the currency symbol.
     *
     * @param int|float $amount
     */
    protected function amountChoicesWithCurrency(&$amount)
    {
        $amount = $this->amountWithCurrency($amount);
    }
}
