<?php
/**
 * Created by PhpStorm.
 * User: Somefive
 * Date: 2016/9/26
 * Time: 16:07
 */
namespace common\widgets;

class ArrayFlattener
{
    public static function flatten($array)
    {
        $result = [];
        foreach($array as $item)
            $result[$item] = $item;
        return $result;
    }
}