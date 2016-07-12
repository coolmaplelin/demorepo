<?php

namespace Mapes\CMSBundle\Utils;


class arrayUtils
{
    public static function aasort (&$array, $key, $is_numeric = false) {
        $sorter=array();
        $ret=array();
        reset($array);
        
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        if($is_numeric)
          asort($sorter, SORT_NUMERIC);
        else 
          asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;

        return $array;
    }
}

?>