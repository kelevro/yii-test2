<?php

namespace backend\components;


use common\base\ActiveRecord;
use yii\web\HttpException;
use Yii;

/**
 * @package backend\components
 */
class Controller extends \common\base\Controller
{
    public $enableCsrfValidation = false;
        
    public $breadcrumbs = [];


    /**
     * Checks access for operation,
     * if not allowed throws HttpException
     *
     * @param string| array $operation
     * @param array $params
     * @return bool
     * @throws
     */
    protected function checkAccess($operation, $params = [])
    {
        if (is_array($operation)) {
            foreach ($operation  as $item) {
                if ($this->hasAccess($item, $params)) {
                    return true;
                }
            }
        }
        if ($this->hasAccess($operation, $params)) {
            return true;
        }

        throw new HttpException(403, 'Not allowed');
    }

    /**
     * Return is current user allow for $operation
     *
     * @param string $operation
     * @param array $params
     * @return bool
     */
    public function hasAccess($operation, $params = [])
    {
        if (\Yii::$app->user->checkAccess('admin')) {
            return true;
        }
        return \Yii::$app->user->checkAccess($operation, $params);
    }


    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && $this->action->id != 'login') {
            $this->goBack(['/user/default/login'])->send();
            return false;
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        // -------------------------------------------------------------------------------------------------------------
        // code below


        if (method_exists($this->module, 'moduleTitle') && list($alias, $title) = $this->module->moduleTitle()) {
            $bread = ['label' => $title];
            if ($alias) {
                $bread['url'] = ['/'.$alias];
            }
            $this->breadcrumbs[] = $bread;
        }

        if (list($alias, $title) = $this->sectionTitle()) {
            $this->breadcrumbs[] = [
                'label' => $title,
                'url'   => [$alias],
            ];
        }

        return true;
    }


    /**
     * @return array url => title
     */
    public function sectionTitle()
    {
        return null;
    }

    /**
     * @param $title
     * @param string|array|null $url
     */
    public function addBreadcrumbs($title, $url = null)
    {
        $this->breadcrumbs[] = [
            'label' => $title,
            'url' => $url,
        ];
    }

    /**
     * @param string $title
     * @param bool $addToBreadcrumbs
     */
    public function setPageTitle($title, $addToBreadcrumbs = true)
    {
        $this->view->title = $title;
        if ($addToBreadcrumbs) {
            $this->addBreadcrumbs($title);
        }
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->view->title;
    }

    /**
     * Saves index page full url with all search params
     *
     * @param $model
     * @param string $fromAction controller/action of index page
     * @param array $default default redirect
     * @return string|array url for redirect
     */
    public function getReturnTo($model, $fromAction, $default = ['index'])
    {
        $returnTo = $default;
        $session = \Yii::$app->session;
        $referrer = \Yii::$app->request->referrer;

        $sessionKey = 'return_'.get_class($model).$model->id;
        $sessionKey2 = 'return_'.get_class($model);

        if (strpos($referrer, $fromAction)) {
            $session[$sessionKey] = $referrer;
            $returnTo = $referrer;
        } else if (!empty($session[$sessionKey])) {
            $returnTo = $session[$sessionKey];
        } else if (!empty($sessionKey2)) {
            $returnTo = $session[$sessionKey2];
        }

        return $returnTo;
    }
}