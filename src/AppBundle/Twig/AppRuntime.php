<?php

declare(strict_types=1);

namespace AppBundle\Twig;

use PaymentBundle\Lib\IpToCountry;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function displayAds(): bool
    {
        $blacklist = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IM', 'IT', 'LT', 'LU', 'LV', 'MC', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK', 'UK'];
        $country = (new IpToCountry($this->request->getClientIp()))->getCountryIsoCode('FR');
        if (\in_array($country, $blacklist)) {
            return false;
        }

        return true;
    }
}
