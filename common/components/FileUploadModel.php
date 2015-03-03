<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadModel extends \yii\base\Model
{
    public $uploadFieldName = 'file';

    /** @var UploadedFile */
    public $file;

    public $uploadDir;

    private $_filename;

    public function rules()
    {
        return array(
            array('uploadDir', 'required'),
            array('file', 'file')
        );
    }

    public function upload()
    {
        if ($this->validate()) {
            return $this->file->saveAs($this->getPath(), true);
        }
        return false;
    }

    public function toJson()
    {
        return Json::encode(array('filelink' => $this->getUrl(), 'filename' => $this->normalizeFilename()));
    }

    public function getPath($path = '')
    {
        if (Yii::$app->user->isGuest) {
            $path = Yii::getAlias($this->uploadDir) . DIRECTORY_SEPARATOR . 'guest';
        } else {
            $path = Yii::getAlias($this->uploadDir) . DIRECTORY_SEPARATOR . Yii::$app->user->id;
        }
        FileHelper::createDirectory($path);
        return $path . DIRECTORY_SEPARATOR . $this->normalizeFilename();
    }

    public function getUrl()
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', str_replace(Yii::getAlias('@webroot'), '', $this->getPath()));
    }

    protected function getExtensionName()
    {
        if (strstr($this->file, '.')) {
            return preg_replace('/^.*?\./', '.', strtolower($this->file));
        }
        return '';
    }

    protected function normalizeFilename()
    {
        if (!$this->_filename) {
            $extensionName = $this->getExtensionName();
            if (!empty($extensionName)) {
                $name = Inflector::slug(preg_replace('/\..*?$/', '', strtolower($this->file)));
                $name .= $extensionName;
            } else {
                $name = strtolower($this->file);
            }
            $this->_filename = substr(uniqid(md5(rand()), true), 0, 10) . '.' . $name;
        }
        return $this->_filename;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName($this->uploadFieldName);
            return true;
        }
        return false;
    }

    public function getFileName()
    {
        return $this->_filename;
    }

    public function getOriginFileName()
    {
        return $this->file->name;
    }

    public function getSize()
    {
        return $this->file->size;
    }

    public function getType()
    {
        return $this->file->type;
    }
}