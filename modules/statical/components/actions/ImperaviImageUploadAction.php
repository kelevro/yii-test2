<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace statical\components\actions;

use statical\components\ImageUploadModel;
use common\components\actions\ImageUploadAction;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImperaviImageUploadAction extends ImageUploadAction
{
    public $uploadParams = [];


    function run()
    {
        if (empty($_FILES)) {
            return null;
        }

        $model = new ImageUploadModel(['uploadParams' => $this->uploadParams, 'uploadFieldName' => 'file']);
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