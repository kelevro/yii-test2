<?php


namespace user\components;
use yii\web\Cookie;
use yii\web\IdentityInterface;


/**
 * Backend user
 *
 * @package backend\components
 */
class User extends \yii\web\User
{
    /**
     * @var \user\models\User
     */
    protected $model;

    const MULTISITE_KEY = '__ms_name';

    /**
     * @inheritdoc
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);

        $this->getModel()->updateLoginDate();
    }

    public function getRole()
    {
        return $this->getModel()->getAssignedRoles();
    }

    /**
     * @return \user\models\User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = \user\models\User::findOne($this->getId());
        }
        return $this->model;
    }

    /**
     * Saves current multisite to session
     *
     * @param string $name key name of multisite
     */
    public function setMultiSiteName($name)
    {
        \Yii::$app->getSession()->set(self::MULTISITE_KEY, $name);
    }

    /**
     * @return string
     */
    public function getMultiSiteName()
    {
        $list = \Y::msManager()->getMultiSites();
        reset($list);
        list($first) = each($list);
        return \Yii::$app->getSession()->get(self::MULTISITE_KEY, $first);
    }

    public function switchIdentity($identity, $duration = 0)
    {
        $session = \Yii::$app->getSession();
        $this->setIdentity($identity);
        $session->remove($this->idParam);
        $session->remove($this->authTimeoutParam);
        if ($identity instanceof IdentityInterface) {
            $session->set($this->idParam, $identity->getId());
            if ($this->authTimeout !== null) {
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
            if ($duration > 0 && $this->enableAutoLogin) {
                $this->sendIdentityCookie($identity, $duration);
            }
        } elseif ($this->enableAutoLogin) {
            \Yii::$app->getResponse()->getCookies()->remove(new Cookie($this->identityCookie));
        }
    }

}