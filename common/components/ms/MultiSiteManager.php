<?php


namespace common\components\ms;

use multisite2\Exception;
use multisite2\Manager;

/**
 * Extended project multisite manager with help methods
 *
 * @package common\components
 */
class MultiSiteManager extends Manager
{
    /**
     * Find project instance
     *
     * @param string|int $idOrName
     * @return Project
     */
    public function findProject($idOrName)
    {
        return $this->findUnitByIdOrName($idOrName, 'project');
    }

    /**
     * @inheritdoc
     */
    public function setActive($idOrName)
    {
        parent::setActive($idOrName);

        \Yii::$app->urlManager->baseUrl = '';
        \Yii::$app->urlManager->hostInfo = 'http://'.$this->getActive()->getDomain();
    }
}