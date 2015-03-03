<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace product\components;

use common\components\ImageUploadModel;
use product\models\Image;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadAction extends \yii\base\Action
{
    public $uploadParams = [];


    function run()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (empty($_FILES)) {
            return null;
        }

        $model = new ImageUploadModel(['uploadParams' => $this->uploadParams, 'uploadFieldName' => 'files[0]']);

        if ($model->upload()) {
            $title = (isset(\Y::post('title')[$model->getOriginFileName()]))?\Y::post('title')[$model->getOriginFileName()]:'';
            $alt = (isset(\Y::post('alt')[$model->getOriginFileName()]))?\Y::post('alt')[$model->getOriginFileName()]:'';
            $img = new Image([
                'img' => $model->getFileName(),
                'size' => $model->getSize(),
                'title' => $title,
                'alt' => $alt,
                'extension' => $model->getType(),
            ]);
            if ($img->save()) {
                return [ 'files' => [
                    [
                        'deleteType'    => "GET",
                        'deleteUrl'     => Url::toRoute(['/product/product/delete-image', 'image' => $img->id]),
                        'thumbnailUrl'  => $model->getTumbUrl(),
                        'name'          => $model->getFileName(),
                        'size'          => $model->getSize(),
                        'type'          => $model->getType(),
                        'url'           => $model->getUrl(),
                        'title'         => $img->title,
                        'alt'           => $img->alt,
                        'modelId'       => $img->id,
                    ]
                ]];
            }
        }
        if ($model->firstErrors) {
            return ['error' => $model->firstErrors[0]];
        }
    }
}