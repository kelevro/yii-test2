<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\actions;

use common\components\ImageUploadModel;
use yii\helpers\Json;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadAction extends \yii\base\Action
{
    public $uploadParams = [];


    function run()
    {
        if (empty($_FILES)) {
            return null;
        }

        $model = new ImageUploadModel(['uploadParams' => $this->uploadParams]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->upload()) {
            return [
                'status'   => 'success',
                'message'  => 'good!',
                'filelink' => $model->getUrl(),
                'filename' => $model->getFileName(),
            ];
        }

        if ($model->firstErrors) {
            return ['error' => $model->firstErrors[0]];
        }
    }

}