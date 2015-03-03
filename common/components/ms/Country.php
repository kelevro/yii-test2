<?php


namespace common\components\ms;

use multisite2\Unit;

/**
 * Country unit with helper methods
 *
 * @package common\components\ms
 */
class Country extends Unit
{
    /**
     * @return int root region id for current site
     */
    public function getRegionRootId()
    {
        return $this->attributes['region']['root'];
    }

    /**
     * @return int root category id for current site
     */
    public function getJobCategoryRootId()
    {
        return $this->attributes['category']['root'];
    }

    /**
     * @return array ids of top categories levels
     */
    public function getJobCategoryTopLvls()
    {
        return $this->attributes['category']['lvl']['top'];
    }

    /**
     * @return array of position categories levels
     */
    public function getJobCategoryPositionsLvls()
    {
        return $this->attributes['category']['lvl']['position'];
    }

    /**
     * @return int id of content categories root for current site
     */
    public function getContentCategoryRootId()
    {
        return $this->attributes['content']['categoryRoot'];
    }

    /**
     * @return string current site language
     */
    public function getLanguage()
    {
        return $this->attributes['language'];
    }

    public function getSearchJobsSphinxIndex()
    {
        return $this->attributes['sphinx']['index'];
    }
}