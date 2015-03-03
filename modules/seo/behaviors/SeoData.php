<?php


namespace seo\behaviors;

use common\base\ActiveRecord;
use seo\Exception;
use seo\models\SeoRule;
use yii\base\Behavior;

/**
 * Seo Rule Behavior
 *
 * Target model must have method seoRuleParams
 * which return array with route as key and value as routeParams
 *
 *
 * @package seo\behaviors
 */
class SeoData extends Behavior
{
    /**
     * Route and rule params
     * can be array with route as key and value as routeParams
     * or callable with function returns same array format
     *
     * @var mixed
     */
    public $ruleParams;

    /**
     * @var SeoRule
     */
    protected $seoRule;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveSeoData',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveNewSeoData',

            ActiveRecord::EVENT_BEFORE_VALIDATE => 'validateSeoData',

            ActiveRecord::EVENT_AFTER_DELETE => 'deleteSeoData',
        ];
    }

    /**
     * Load seo rule attributes from post array
     *
     * @param array $data
     * @return bool
     */
    public function loadSeoData($data)
    {
        return $this->getSeoData()->load($data);
    }

    /**
     * Validates seo rule model
     *
     * @return bool
     */
    public function validateSeoData()
    {
        if (!$this->getSeoData()->enabled) {
            return true;
        }
        $tmp = $this->getSeoData()->validate($this->getSeoData()->metaAttributes());
        return $tmp;
    }


    /**
     * Saves seo rule model
     * if model is not new and $isEnabled is false, it will delete record
     *
     * @return bool
     */
    public function saveSeoData()
    {
        if ($this->getSeoData()->enabled) {
            return $this->getSeoData()->save(false);
        } else {
            if (!$this->getSeoData()->getIsNewRecord()) {
                $this->deleteSeoData();
            }
            return true;
        }
    }

    public function saveNewSeoData()
    {
        if (!$this->getSeoData()->enabled) {
            return false;
        }

        list($route, $params) = $this->getSeoRuleParams();
        $this->seoRule->route = $route;
        $this->seoRule->setAttributes($params);

        if (!$this->seoRule->save()) {
            throw new Exception('Unable to insert new seo rule, validation errors: ' . implode(', ', $this->seoRule->getFirstErrors()));
        }
        return true;
    }

    /**
     * Deletes seo rule record
     */
    public function deleteSeoData()
    {
        $this->getSeoData()->delete();
    }


    /**
     * Gets route params from owner model
     *
     * @return array
     */
    protected function getSeoRuleParams()
    {
        if (is_array($this->ruleParams)) {
            return $this->ruleParams;
        }
        return call_user_func($this->ruleParams);
    }


    /**
     * Create seo rule model with owner model route params
     *
     * @return SeoRule
     */
    protected function createRuleModel()
    {
        list($route, $params) = $this->getSeoRuleParams();
        return SeoRule::findByRouteOrCreate($route, $params);
    }

    /**
     * Gets cached seo rule
     *
     * @return SeoRule
     */
    public function getSeoData()
    {
        if (!$this->seoRule) {
            $this->seoRule = $this->createRuleModel();
            $this->seoRule->enabled = !$this->seoRule->isNewRecord;
        }
        return $this->seoRule;
    }

    /**
     * Checks if owner model has seo data record
     *
     * @return bool
     */
    public function getHasSeoData()
    {
        list($route, $params) = $this->getSeoRuleParams();
        return (bool)SeoRule::findByRoute($route, $params);
    }
}