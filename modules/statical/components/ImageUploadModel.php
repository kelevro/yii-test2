<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace statical\components;

use common\components\FileUploadModel;
use Imagick;
use \common\helpers\Storage;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class ImageUploadModel extends FileUploadModel
{

    /** @var  array
     *  example [['path' => '@web/path1', 'size' => [100, 100]] ... ]
     */
    public $uploadParams = [];

    private $originFilePath = '';

    private $mainFile = '';

    public function rules()
    {
        return array(
            array('uploadParams', 'required'),
            array('file', 'file', 'types' => 'jpg,png,gif,bmp,jpe,jpeg,jpeg')
        );
    }

    public function upload()
    {
        $result = false;
        if ($this->validate()) {
            $result = $this->processImage();
            if (!empty($this->uploadParams['thumbnails']) && is_array($this->uploadParams['thumbnails'])) {
                foreach ($this->uploadParams['thumbnails'] as $params) {
                    $result = $this->processThumbnailsImage($params);
                }
            }
        }
        return $result;
    }

    protected function processImage()
    {
        $this->originFilePath = $this->getPath($this->uploadParams['origin_path']);
        return $this->file->saveAs($this->originFilePath, true);
    }

    /**
     * Resize image
     *
     * @param array $param
     * @return string
     */
    protected function processThumbnailsImage($param)
    {
        $imagick = new Imagick($this->originFilePath);
        $imagick->resizeimage($param['size']['width'], $param['size']['height'],
                              Imagick::FILTER_LANCZOS, 1, $param['bestfit']);
        $filePath = $this->getPath($param['path']);
        if (!empty($param['is_main'])) {
            $this->mainFile = $param['path'];
        }
        return $imagick->writeimage($filePath);
    }

    public function getPath($path = '')
    {
        return Storage::getStoragePathTo($path) . $this->normalizeFilename();
    }

    public function getUrl()
    {
        return  Storage::getStorageUrlTo($this->getMainFile()) . DS . $this->getFileName();
    }

    public function getMainFile()
    {
        return (!empty($this->mainFile)) ? $this->mainFile : $this->uploadParams['origin_path'];
    }
}