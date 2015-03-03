<?php

namespace backend\components;

use yii\widgets\ActiveField;

/**
 * @inheritdoc
 */
class TBSField extends ActiveField
{
    public function tooltip($text)
    {
        $this->inputOptions['data-toggle'] = 'tooltip';
        $this->inputOptions['data-trigger'] = 'focus';
        $this->inputOptions['data-placement'] = 'top';
        $this->inputOptions['data-original-title'] = $text;

        return $this;
    }
}