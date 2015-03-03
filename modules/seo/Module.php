<?php

namespace seo;
use seo\models\SeoRule;

/**
 * Seo module
 * manage seo titles, metas, seo texts, etc
 *
 * @package seo
 */
class Module extends \common\base\Module
{
    /**
     * @var array list of rule models
     */
    public $ruleModels = [];

    private $_modelsWithRules;

    public function moduleTitle()
    {
        return [null, 'Seo'];
    }

    /**
     * Returns list of model classes as keys and array with routes as value
     *  \content\models\seo\ArticleRule => ['content\content\article'],
     *  \content\models\seo\CategoryRule => ['content\content\category'],
     *
     * @return array
     */
    public function getRulesRoutes()
    {
        if ($this->_modelsWithRules == null) {
            $this->_modelsWithRules = [];
            foreach($this->ruleModels as $modelClass) {
                /** @var SeoRule $model */
                $model = new $modelClass;
                $this->_modelsWithRules[$model::className()] = $model->getRoutes();
            }
        }
        return $this->_modelsWithRules;
    }

    /**
     * @param string $route
     * @return string|null
     */
    public function findModelClassForRoute($route)
    {
        $route = trim($route, '/');
        foreach ($this->getRulesRoutes() as $modelClass => $routes) {
            if (in_array($route, $routes)) {
                return $modelClass;
            }
        }
        return null;
    }

    /**
     * @return array list route => title
     */
    public function getRoutesWithTitles()
    {
        $items = [];
        foreach ($this->ruleModels as $modelClass) {
            foreach ((new $modelClass)->getRoutesWithTitles() as $route => $title) {
                $items[$route] = $title;
            }
        }
        return $items;
    }

    /**
     * @return array model class => title
     */
    public function getModelsWithTitles()
    {
        $items = [];
        foreach ($this->ruleModels as $modelClass) {
            /** @var SeoRule $model */
            $model = new $modelClass;
            $items[$modelClass] = $model->title();
        }
        return $items;
    }
}