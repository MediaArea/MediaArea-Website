<?php

namespace PaymentBundle\Lib;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class IpToCountry
{
    protected $country;

    /**
     * Constructor.
     *
     * @param string $ip IP address
     */
    public function __construct($ip = '127.0.0.1')
    {
        /*
        $geoipDb = new Database();
        $reader = new Reader($geoipDb->getLocation());
        */
        $reader = new Reader(__DIR__.'/../../../var/data/GeoLite2-Country.mmdb');
        try {
            $this->country = $reader->country($ip)->country;
        } catch (AddressNotFoundException $e) {
            $this->country = null;
        }
    }

    /**
     * Get country ISO code from ip address (IPv4/IPv6).
     *
     * @param string $defaultCountry Default country if ip address is unknown
     *
     * @return string Country ISO code
     */
    public function getCountryIsoCode($defaultCountry = 'XX')
    {
        if ($this->country) {
            return $this->country->isoCode;
        }

        return $defaultCountry;
    }

    /**
     * Get country name from ip address (IPv4/IPv6).
     *
     * @param string $defaultCountry Default country if ip address is unknown
     *
     * @return string Country name
     */
    public function getCountryName($defaultCountry = 'XX')
    {
        if ($this->country) {
            return $this->country->names['en'];
        }

        return $defaultCountry;
    }
}
