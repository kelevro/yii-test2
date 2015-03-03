<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\actions;

use common\components\FileUploadModel;
use yii\helpers\Json;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadAction extends \yii\base\Action
{
    public $uploadDir = '@webroot/uploads';

    public function run()
    {
        if (isset($_FILES)) {
            $model = new FileUploadModel(array('uploadDir' => $this->uploadDir));
            if ($model->upload()) {
                echo $model->toJson();
            } else {
                if ($model->firstErrors) {
                    echo Json::encode(array('error' => $model->firstErrors[0]));
                }
            }
        }
    }

}