<?php


namespace product\models\seo;

use seo\models\SeoRule;

/**
 * Rule for category
 *
 * @package content\models\seo
 */
class CategoryRule extends SeoRule
{
    public $category;

    /**
     * Page header
     *
     * @var string
     */
    public $h1;

    public function routes()
    {
        return ['/product/default/category'];
    }


    /**
     * @inheritdoc
     */
    public function routeRules()
    {
        return [
            [['category', 'meta_title', 'meta_desc'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function routeAttributes()
    {
        return ['category'];
    }

    public function metaAttributes()
    {
        return ['h1'];
    }

    public function metaRules()
    {
        return [
            ['h1', 'safe'],
        ];
    }

    public function viewFile()
    {
        return '@product/views/seo/category-form.php';
    }
}