<?php


namespace common\base;

use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Base common controller
 *
 * @property string $pageTitle
 * @property string $errorFlash
 * @property string $flash
 *
 * @package common\base
 */
class Controller extends \yii\web\Controller
{

    /**
     * Default model id GET param name for edit actions
     *
     * @var string
     */
    protected $modelIdParam = 'id';

    /**
     * Loads model by it id or throw http exception if it not found
     *
     * @param string $modelClass
     * @param int $modelId
     * @return ActiveRecord
     * @throws HttpException
     */
    protected function loadModel($modelClass, $modelId = null)
    {
        if ($modelId === null && empty($_GET[$this->modelIdParam])) {
            throw new HttpException(400, 'No model id');
        }
        $id = $modelId === null ? $_GET[$this->modelIdParam] : $modelId;
        $model = $modelClass::findOne($id);
        if ($model == null) {
            throw new HttpException(404, "Model '{$model}' record #{$id} is not found");
        }
        return $model;
    }

    /**
     * Load model if exists id or create new instance
     *
     * @param string $modelClass
     * @param null|int $modelId
     * @return ActiveRecord
     */
    protected function loadOrCreateModel($modelClass, $modelId = null)
    {
        if ($modelId === null && empty($_GET[$this->modelIdParam])) {
            return new $modelClass;
        }
        return $this->loadModel($modelClass, $modelId);
    }


    /**
     * Sets user flash
     *
     * @param string $message
     * @param string $type flash type, default is 'success'
     */
    public function setFlash($message, $type = 'success')
    {
        \Yii::$app->session->setFlash($type, $message);
    }

    /**
     * Sets error user flash
     *
     * @param string $message
     */
    public function setErrorFlash($message)
    {
        $this->setFlash($message, 'error');
    }

    /**
     * @param string $message
     */
    public function setInfoFlash($message)
    {
        $this->setFlash($message, 'info');
    }


    /**
     * Output JSON data with success result and end application
     *
     * @param string $message
     * @param array $data
     */
    public function endJson($message = '', $data = array())
    {
        echo Json::encode(array(
            'result' => 'ok',
            'message' => $message,
            'data' => $data,
        ));
        exit;
    }

    /**
     * Output JSON data with error result and end application
     *
     * @param string $message
     * @param array $data
     */
    public function errorJson($message = '', $data = array())
    {
        echo Json::encode(array(
            'result' => 'error',
            'message' => $message,
            'data' => $data,
        ));
        exit;
    }

}