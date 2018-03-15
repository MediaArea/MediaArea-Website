<?php

namespace MediaBinBundle\Lib;

use MediaBinBundle\Model\BinInterface;

class XMLValidator
{
    /**
     * Check if a xml is valid.
     *
     * @param string $xml  XML content
     * @param int    $type Type of XML (to get associated schema)
     *
     * @return bool
     */
    public function isValid($xml, $type)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'utf-8');
        if (false === $dom->loadXML($xml, LIBXML_NOBLANKS)) {
            return false;
        }

        switch ($type) {
            case BinInterface::FORMAT_MEDIAINFO:
                return $dom->schemaValidate(__DIR__.'/../Resources/xml/mediainfo_2_0.xsd');
                break;

            default:
                return false;
                break;
        }
    }
}
