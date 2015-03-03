<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Implodes array with key value
     *
     * @param array $array
     * @param string $keyValueSeparator
     * @param string $itemSeparator
     * @return string
     */
    public static function implodeKeyValue(array $array, $keyValueSeparator = '=', $itemSeparator = ',')
    {
        $items = [];
        foreach ($array as $k => $v) {
            $items[] = $k.$keyValueSeparator.$v;
        }
        return implode($itemSeparator, $items);
    }

    /**
     * Creates array from string packet by implodeKeyValue
     *
     * @param string $string
     * @param string $keyValueSeparator
     * @param string $itemSeparator
     * @return array
     */
    public static function explodeKeyValue($string, $keyValueSeparator = '=', $itemSeparator = ',')
    {
        $items = [];
        foreach (explode($itemSeparator, $string) as $item) {
            list($k, $v) = explode($keyValueSeparator, $item);
            $items[$k] = $v;
        }

        return $items;
    }
}