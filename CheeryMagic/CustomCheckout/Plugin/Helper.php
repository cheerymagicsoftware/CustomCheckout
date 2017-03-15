<?php

namespace CheeryMagic\CustomCheckout\Plugin;


class Helper
{

    /**
     * @param $pathInfo
     * @return array
     */

    public static function getArrayPathInfo($pathInfo)
    {
        $array = [];
        if ($pathInfo === '')
            return $array;
        $segs = explode('/', $pathInfo . '/');
        $n = count($segs);
        for ($i = 0; $i < $n - 1; $i++) {
            $key = $segs[$i];
            if ($key === '') continue;
            if (!(($pos = strpos($key, '[')) !== false && ($m = preg_match_all('/\[(.*?)\]/', $key, $matches)) > 0))
                $array[] = $key;
        }
        return $array;
    }
}