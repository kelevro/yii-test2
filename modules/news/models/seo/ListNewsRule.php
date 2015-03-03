<?php


namespace news\models\seo;

use seo\models\SeoRule;

/**
 * Seo rule for list news
 *
 * @package content\models\seo
 */
class ListNewsRule extends SeoRule
{

    public function routes()
    {
        return ['/news/default/index'];
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
        return [];
    }
}