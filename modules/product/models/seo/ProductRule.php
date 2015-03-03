<?php


namespace product\models\seo;

use seo\models\SeoRule;

/**
 * Seo rule for product
 *
 * @package content\models\seo
 */
class ProductRule extends SeoRule
{
    /**
     * @var int
     */
    public $product;

    public function routes()
    {
        return ['/product/default/product'];
    }


    /**
     * @inheritdoc
     */
    public function routeRules()
    {
        return [
            [['product', 'meta_title', 'meta_desc'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function routeAttributes()
    {
        return ['product'];
    }
}