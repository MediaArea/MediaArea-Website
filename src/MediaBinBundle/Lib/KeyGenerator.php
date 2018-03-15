<?php

namespace MediaBinBundle\Lib;

class KeyGenerator
{
    const KEYVALUES = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * Generates a random key using base62 characters.
     *
     * @return key in base62 string
     */
    public static function getKey()
    {
        $arr = str_split(self::KEYVALUES);
        shuffle($arr);

        return implode('', array_slice($arr, 0, 8));
    }
}
