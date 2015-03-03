<?php


namespace seo\models;

use common\base\ActiveRecord;
use common\helpers\ArrayHelper;
use seo\Module;

/**
 * Base model for seo rules
 *
 * @property int $id
 * @property int $project_id
 * @property string $route
 * @property string $route_params
 * @property string $model
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_attributes
 * @property string $date_created
 * @property string $date_updated
 *
 * @package seo\models
 */
class SeoRule extends ActiveRecord
{
    /**
     * Virtual field, using only for edit form
     * If value is false, model will ignore data and does not validates
     *
     * @var bool
     */
    public $enabled = false;


    public static function tableName()
    {
        return 'seo_rule';
    }

    /**
     * Return list of params for route
     *
     * @return array
     */
    public function routeAttributes()
    {
        return [];
    }

    /**
     * Rules for validate route params in nested model
     *
     * @return array
     */
    public function routeRules()
    {
        return [];
    }


    /**
     * Returns list of routes for this model
     * can return only routes or
     * route => title of this route
     *
     * @return array
     */
    public function routes()
    {
        return [];
    }

    /**
     * @return array list of routes
     */
    public function getRoutes()
    {
        $items = [];
        foreach ($this->routes() as $route => $title) {
            if (is_int($route)) {
                $route = $title;
            }
            $items[] = trim($route, '/');
        }
        return $items;
    }

    /**
     * Returns routes list with titles:
     *  route => title
     *
     * @return array
     */
    public function getRoutesWithTitles()
    {
        $items = [];
        foreach ($this->routes() as $route => $title) {
            if (is_int($route)) {
                $route = $title;
                $title = $this->title();
            }
            $items[$route] = $title;
        }
        return $items;
    }

    /**
     * @return string path to view file
     */
    public function viewFile()
    {
        return null;
    }

    /**
     * @return string title for model
     */
    public function title()
    {
        return null;
    }


    /**
     * Return list of additional seo attributes, for example: seo texts, titles, etc
     *
     * @return array
     */
    public function metaAttributes()
    {
        return ['meta_title', 'meta_desc'];
    }

    /**
     * Return list of validation rules for additional meta attributes
     *
     * @return array
     */
    public function metaRules()
    {
        return [];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['route', 'required'],
            [['meta_title', 'meta_desc'], '\common\validators\StringValidator', 'max' => 160, 'withoutSpaces' => true],
            ['route', 'in', 'range' => $this->getRoutes()],
            ['enabled', 'boolean'],
        ];

        $route = $this->routeRules();
        $meta  = $this->metaRules();

        return array_merge($rules, $route, $meta);
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return parent::attributes();
    }

    private static function serializeRouteAttrs($attributes)
    {
        $attributes = array_filter($attributes);
        ksort($attributes);
        return ArrayHelper::implodeKeyValue($attributes) ?: null;
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $this->model = static::className();

        if ($routeAttrs = $this->getAttributes($this->routeAttributes())) {
            $this->route_params = self::serializeRouteAttrs($routeAttrs);
        } else {
            $this->route_params = null;
        }

        if ($metaAttrs = $this->getAttributes($this->metaAttributes())) {
            $this->meta_attributes = json_encode(array_filter($metaAttrs));
        } else {
            $this->meta_attributes = null;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();

        if ($this->route_params && $params = ArrayHelper::explodeKeyValue($this->route_params)) {
            foreach ($params as $k => $v) {
                $this->{$k} = $v;
            }
        }

        if ($this->meta_attributes && $params = json_decode($this->meta_attributes, true)) {
            foreach ($params as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    /**
     * @return bool if has user data
     */
    public function getIsHasData()
    {
        if (!$this->getIsNewRecord()) {
            return true;
        }

        if ($this->meta_title || $this->meta_desc) {
            return true;
        }

        foreach ($this->metaAttributes() as $attr) {
            if ($this->$attr) {
                return true;
            }
        }

        return false;
    }

    /**
     * Init model route params from given array
     * it will use only values from routeAttributes() list
     *
     * @param array $params
     */
    public function loadRouteParams($params)
    {
        foreach (self::filterParams(static::className(), $params) as $k => $v) {
            $this->{$k} = $v;
        }
    }

    /**
     * Find model by route and params
     *
     * @param string $route
     * @param array $params
     * @return self
     */
    public static function findByRoute($route, $params)
    {
        /** @var Module $module */
        $module = \Yii::$app->getModule('seo');
        if (($class = $module->findModelClassForRoute($route)) == null) {
            return null;
        }

        return $class::findOne([
            'model'        => $class,
            'route'        => $route,
            'route_params' => self::serializeRouteAttrs(SeoRule::filterParams($class, $params)),
        ]);
    }

    /**
     * @inheritdoc
     * @return SeoRule
     */
    public static function instantiate($row)
    {
        return new $row['model'];
    }

    /**
     * Filter params for model
     * uses for get from $_GET only needed params for model
     *
     * @param string $modelClass
     * @param array $params
     * @return array
     */
    public static function filterParams($modelClass, $params)
    {
        $ruleRouteAttributes = (new $modelClass)->routeAttributes();
        return array_intersect_key($params, array_combine($ruleRouteAttributes, $ruleRouteAttributes));
    }


    /**
     * Find seo rule model by route or create
     *
     * @param string $route
     * @param array $routeParams
     * @return SeoRule
     */
    public static function findByRouteOrCreate($route, $routeParams)
    {
        /** @var Module $module */
        $module = \Yii::$app->getModule('seo');

        if (($modelClass = $module->findModelClassForRoute($route)) == null) {
            return null;
        }

        /** @var SeoRule $model */
        if (($model = $modelClass::findByRoute($route, SeoRule::filterParams($modelClass, $routeParams))) == null) {
            $model = new $modelClass;
            $model->route = $route;
            $model->loadRouteParams($routeParams);
        }

        return $model;
    }
}