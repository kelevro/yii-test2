<?php


namespace common\components\ms;
use multisite2\Unit;

/**
 * Project unit
 * For now it's inherit Country
 *
 * @package common\components\ms
 */
class Project extends Unit
{
    protected $country;

    /**
     * @return Country
     */
    protected function getCountry()
    {
        if (!$this->country) {
            $this->country = $this->manager->findUnitByIdOrName($this->attributes['country'], 'country');
        }
        return $this->country;
    }

    function __call($name, $arguments)
    {
        return call_user_func_array([$this->getCountry(), $name], $arguments);
    }

    public function getMultisites()
    {
        $multisites = [];
        foreach ($this->manager->getMultiSites() as $ms) {
            if ($ms->getUnit('project')->id == $this->id) {
                $multisites[] = $ms;
            }
        }
        return $multisites;
    }
}