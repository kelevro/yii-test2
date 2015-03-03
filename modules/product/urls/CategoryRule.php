<?php


namespace product\urls;

use yii\base\Exception;
use product\models\Category;
use yii\helpers\ArrayHelper;
use yii\web\UrlRule;

/**
 * Class CategoryRule
 * @package content\urls
 */
class CategoryRule extends UrlRule
{
    /**
     * @var string
     */
    public $route = 'product/default/category';

    public function init()
    {}

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params)
    {
        if ($this->route != $route) {
            return false;
        }

        if (empty($params['category'])) {
            throw new Exception("No required param 'category'");
            }

        if (is_numeric($params['category'])) {
            $category = Category::find()
                ->andWhere(['id' => $params['category']])
                ->one();

            if ($category == null) {
                throw new Exception("Category #{$params['category']} is not found");
            }
        } else if ($params['category'] instanceof Category) {
            if ($params['category']->getIsNewRecord()) {
                throw new Exception('Category instance must be saved');
            }
            $category = $params['category'];
        }
        unset($params['category']);

        $page = !empty($params['page']) ? intval($params['page']) : 1;
        unset($params['page']);

        $url = '';

        /** @var Category $category */
        $ancestors = $category->ancestors()
            ->asArray()
            ->all();
        if ($ancestors) {
            $url .= implode('/', ArrayHelper::getColumn($ancestors, 'slug')) . '/';
        }

        $url .= $category->slug . '/';

        if ($page > 1) {
            $url .= 'page-'.$page . '/';
        }

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        if (($pi = $request->getPathInfo()) == null) {
            return false;
        }

        $rootCategory = Category::find()
            ->select('id, slug')
            ->andWhere(['lvl' => 1])
            ->one();

        if ($rootCategory && strpos($pi, $rootCategory['slug']) !== 0) {
            return false;
        }

        $pi = substr($pi, strlen($rootCategory['slug']));
        $pieces = explode('/', trim($pi, '/'));

        $page = 1;
        if ($pieces) {
            $last = end($pieces);
            if (preg_match('/page-(\d+)/', $last, $matches)) {
                $page = (int)$matches[1];
                array_pop($pieces);
            }
        }

        if (empty($pieces[0])) {
            return [$this->route, ['category' => intval($rootCategory['id']), 'page' => $page]];
        }

        /** @var Category $category */
        $category = null;
        foreach ($pieces as $slug) {
            if ($category == null) {
                $category = Category::find()
                    ->andWhere('slug = :slug AND lvl >= :lvl', [':slug' => $slug, ':lvl' => 2])
                    ->one();
            } else {
                $category = Category::find()
                    ->andWhere('slug = :slug AND lft >= :lft AND rgt <= :rgt', [
                        ':slug' => $slug,
                        ':lft'  => $category->lft,
                        ':rgt'  => $category->rgt,
                    ])
                    ->one();
            }
            if (!$category) {
                return false;
            }
        }

        return [$this->route, ['category' => intval($category->id), 'page' => $page]];
    }
}