<?php


namespace common\assets;

use yii\web\AssetBundle;

/**
 * Assets for all widgets
 *
 */
class JqueryFileUploader extends AssetBundle
{
    public $sourcePath = '@common/assets/jquery-file-uploader';

    public $js = [
        'http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js',
        'js/load-image.all.min.js',
        'http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js',
        'http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js',
        'js/vendor/jquery.ui.widget.js',
        'js/jquery.iframe-transport.js',
        'js/jquery.fileupload.js',
        'js/jquery.fileupload-process.js',
        'js/jquery.fileupload-image.js',
        'js/jquery.fileupload-validate.js',
        'js/jquery.fileupload-ui.js',
        'js/main.js',
    ];

    public $css = [
        'css/style.css',
        'http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css',
        'css/jquery.fileupload.css',
        'css/jquery.fileupload-ui.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}