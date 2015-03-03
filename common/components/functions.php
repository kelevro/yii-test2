<?php


function sqldate($timestamp = null) {
    $format = 'Y-m-d H:i:s';
    return (empty($timestamp)) ? date($format) : date($format, $timestamp);
}


function d($var, $end = true)
{
    print_r($var);
    if ($end) die;
}

function dd($var, $end = true)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if ($end) die;
}


function _t($category, $message, $params = array(), $language = null)
{
    return \Yii::t($category, $message, $params, $language);
}

function __t($category, $message, $params = array(), $language = null)
{
    echo \Yii::t($category, $message, $params, $language);
}


if (0) {
    /**
     * @param $array
     * @param $column
     * @return array
     */
    function array_column($array, $column) {}
}