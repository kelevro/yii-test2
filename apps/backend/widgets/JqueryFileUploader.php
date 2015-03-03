<?php


namespace backend\widgets;

use yii\base\Widget;


/**
 * Sir Trevor widget
 *
 * @package backend\widgets
 */
class JqueryFileUploader extends Widget
{
    public $fileName = 'jquery-file-uploader';
    public $saveUrl;

    public $loadUrl;


    public function init()
    {
        parent::init();
    }


    public function run()
    {
        if (!$this->saveUrl || !$this->loadUrl) {
            return false;
        }
        \common\assets\JqueryFileUploader::register($this->view);

        return $this->render('jquery-file-uploader', [
            'saveUrl' => $this->saveUrl,
            'loadUrl' => $this->loadUrl,
        ]);
    }
}