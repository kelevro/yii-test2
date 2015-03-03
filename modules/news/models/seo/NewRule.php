<?php


namespace news\models\seo;

use seo\models\SeoRule;

/**
 * Seo rule for new
 *
 * @package content\models\seo
 */
class NewRule extends SeoRule
{
    /**
     * @var int
     */
    public $id;

    public function routes()
    {
        return ['/news/default/view'];
    }


    /**
     * @inheritdoc
     */
    public function routeRules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function routeAttributes()
    {
        return ['id'];
    }
}