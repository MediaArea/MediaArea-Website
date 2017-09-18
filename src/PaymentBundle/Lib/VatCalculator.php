<?php

namespace PaymentBundle\Lib;

class VatCalculator
{
    /**
     * VAT rate by country.
     *
     * @var array
     */
    protected $vatRate = [
        'AT' => 0.20, // Austria
        'BE' => 0.21, // Belgium
        'BG' => 0.20, // Bulgaria
        'CY' => 0.19, // Cyprus
        'CZ' => 0.21, // Czech Republic
        'DE' => 0.19, // Germany
        'DK' => 0.25, // Denmark
        'EE' => 0.20, // Estonia
        'ES' => 0.21, // Spain
        'FI' => 0.24, // Finland
        'FR' => 0.20, // France
        'GB' => 0.20, // United Kingdom
        'GR' => 0.24, // Greece
        'HR' => 0.25, // Croatia
        'HU' => 0.27, // Hungary
        'IE' => 0.23, // Ireland
        'IM' => 0.20, // Isle of Man (United Kingdom)
        'IT' => 0.22, // Italy
        'LT' => 0.21, // Lithuania
        'LU' => 0.17, // Luxembourg
        'LV' => 0.21, // Latvia
        'MC' => 0.20, // Monaco (France)
        'MT' => 0.18, // Malta
        'NL' => 0.21, // Netherlands
        'PL' => 0.23, // Poland
        'PT' => 0.23, // Portugal
        'RO' => 0.19, // Romania
        'SE' => 0.25, // Sweden
        'SI' => 0.22, // Slovenia
        'SK' => 0.20, // Slovakia
    ];

    /**
     * Gross price.
     *
     * @var float
     */
    protected $gross;

    /**
     * Net price.
     *
     * @var float
     */
    protected $net;

    /**
     * Vat amout.
     *
     * @var float
     */
    protected $vat;

    /**
     * Country ISO code.
     *
     * @var string
     */
    protected $country;

    /**
     * Set gross value.
     *
     * @param int|float $gross Gross value
     *
     * @return VatCalculator
     */
    public function setGross($gross)
    {
        $this->gross = floatval($gross);

        return $this;
    }

    /**
     * Set country ISO code value.
     *
     * @param string $country Country ISO code
     *
     * @return VatCalculator
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get gross value.
     *
     * @return float Gross value
     */
    public function getGross()
    {
        return $this->gross;
    }

    /**
     * Get net value.
     *
     * @return float Net value
     */
    public function getNet()
    {
        return $this->net;
    }

    /**
     * Get vat amount.
     *
     * @return float Vat amount
     */
    public function getVatAmount()
    {
        return $this->vat;
    }

    /**
     * Calculate net price and vat amount from gross price.
     */
    public function calculateNet()
    {
        if (isset($this->vatRate[$this->country])) {
            $this->net = round($this->gross / (1 + $this->vatRate[$this->country]), 2);
            $this->vat = $this->gross - $this->net;
        } else {
            $this->vat = 0;
            $this->net = $this->gross;
        }
    }
}
