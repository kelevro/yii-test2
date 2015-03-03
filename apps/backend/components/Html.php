<?php


namespace backend\components;

class Html extends \yii\helpers\Html
{
    /**
     * @inheritdoc
     */
    public static function button($content = 'Button', $options = [])
    {
        if (empty($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' btn';
        return parent::button($content, $options);
    }

    /**
     * @inheritdoc
     */
    public static function submitButton($content = 'Submit', $options = [])
    {
        if (empty($options['class'])) {
            $options['class'] = 'btn-success';
        }
        return parent::submitButton($content, $options);
    }

    /**
     * @inheritdoc
     */
    public static function a($text, $url = null, $options = [])
    {
        if (!empty($options['icon'])) {
            $text = '<i class="fa '.$options['icon'].'"></i> ' . $text;
        }

        return parent::a($text, $url, $options);
    }
}