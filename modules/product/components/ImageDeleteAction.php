<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace product\components;

use common\helpers\Storage;
use product\models\Image;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageDeleteAction extends \yii\base\Action
{
    public $uploadParams = [];

    public $imageId;


    function run()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!$image = Image::findOne($this->imageId)) {
            return false;
        }

        if (!empty($this->uploadParams['origin_path'])) {
            unlink(Storage::getStoragePathTo($this->uploadParams['origin_path']) . $image->img);
        }

        if (!empty($this->uploadParams['thumbnails']) && is_array($this->uploadParams['thumbnails'])) {
            foreach ($this->uploadParams['thumbnails'] as $param) {
                unlink(Storage::getStoragePathTo($param['path']) . $image->img);
            }
        }

        $image->delete();

        return true;
    }
}