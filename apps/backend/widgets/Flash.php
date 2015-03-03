<?php


namespace backend\widgets;

use yii\base\Widget;

class Flash extends Widget
{
    public function run()
    {
        $flashes = \Yii::$app->session->getAllFlashes();
        \Yii::$app->session->removeAllFlashes();

        echo $this->render('flash', [
            'flashes' => $flashes,
        ]);
    }

    public function iconForType($type)
    {
        switch ($type) {
            case 'success':
                return 'fa-check-circle';
            case 'error':
                return 'fa-times-circle';
            case 'info':
                return 'fa-exclamation-circle';
            default:
                return '';
        }
    }

    public function classForType($type)
    {
        switch ($type) {
            case 'error':
                return 'danger';
            default:
                return $type;
        }
    }
}