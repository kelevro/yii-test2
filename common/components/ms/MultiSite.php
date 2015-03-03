<?php


namespace common\components\ms;

/**
 * Project specific multisite component
 *
 * @package common\components
 */
class MultiSite extends \multisite2\MultiSite
{
    const DOMAIN                = 'domain';

    public $theme;

    #region project Functions

    /**
     * @return int id of regions root for current site
     */
    public function getRegionRootId()
    {
        return $this->getUnit('project')->getRegionRootId();
    }

    /**
     * @return string current site language
     */
    public function getLanguage()
    {
        return $this->getUnit('project')->getLanguage();
    }

    #endregion

    /**
     * @return int project id for current site
     */
    public function getProjectId()
    {
        return $this->getUnit('project')->id;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->attributes[self::DOMAIN];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->attributes['title'];
    }

    public function getAlias()
    {
        return $this->attributes['alias'];
    }

    /**
     * @return string
     */
    public function getSearchJobsSphinxIndex()
    {
        return $this->getUnit('project')->getSearchJobsSphinxIndex();
    }
    
    public function getStorageDomain()
    {
        return $this->attributes['storage'];
    }
}