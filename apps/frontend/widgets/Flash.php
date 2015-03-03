<?php


namespace frontend\widgets;

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
                return 'fa-check';
            case 'error':
                return 'fa-times-circle';
            case 'info':
                return 'fa-info-circle';
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

    public function getStatusMessage($type)
    {
        switch ($type) {
            case 'success':
                return 'Success!';
            case 'error':
                return 'Error!';
            case 'info':
                return 'Info!';
            default:
                return '';
        }
    }
}