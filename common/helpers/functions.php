<?php

function sqldate($timestamp = null)
{
    $format = "Y-m-d H:i:s";
    return (empty($timestamp)) ? date($format) : date($format, $timestamp);
}

function _t($cat, $message, $params = array())
{
    return Yii::t($cat, $message, $params);
}

function __t($cat, $message, $params = array())
{
    echo Yii::t($cat, $message, $params);
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

function rrmdir($dir)
{
    if (!is_dir($dir)) {
        return false;
    }
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}