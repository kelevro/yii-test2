<?php


namespace backend\widgets\assets\imperaviRedactor;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Assets for all widgets
 *
 * @package backend\widgets
 */
class ImperaviRedactorBundle extends AssetBundle
{
    public $sourcePath = '@backend/widgets/assets/imperaviRedactor';

    public $js = [
        'js/redactor.js'
    ];

    public $css = [
        'css/redactor.css'
    ];

    public $depends = [
        'backend\assets\BackendBundle'
    ];

    public function registerLangJsFile($lang)
    {
        $this->js[] = "js/lang/{$lang}.js";
    }

}