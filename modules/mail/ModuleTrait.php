<?php


namespace mail;

trait ModuleTrait
{
    /**
     * @return Module
     */
    public static function module()
    {
        return \Yii::$app->getModule('mail');
    }
}