<?php
namespace statical\urls;

use yii\base\Exception;
use statical\models\Page;
use yii\caching\GroupDependency;
use yii\web\UrlRule;

/**
 * Content article url rule
 *
 * @package content\urls
 */
class pageRule extends UrlRule
{
    /**
     * @var string
     */
    public $urlPrefix = '';


    /**
     * @var string
     */
    public $route = 'statical/page/view';

    /**
     * Route for redirect
     * for case when article id has page slug
     *
     * @var string
     */
    public $redirectRoute = 'statical/page/page-redirect';

    /**
     * @var string
     */
    public $urlSuffix = 'html';

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

        if (empty($params['alias'])) {
            throw new Exception("No required param 'page'");
        }

        if (is_string($params['alias'])) { // article by alias
            $pageData = Page::find()
                ->select('id, slug')
                ->andWhere(['alias' => $params['alias']])
                ->asArray()
                ->one();
            if ($pageData == null) {
                throw new Exception("Page #{$params['alias']} is not found");
            }
        } else {
            throw new Exception("Unknown 'alias' input param");
        }
        unset($params['alias']);

        $url = $pageData['slug'];

        if ($this->urlSuffix) {
            $url .= '.'.$this->urlSuffix;
        }

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $this->urlPrefix . $url;
    }


    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        if (($pi = $request->getPathInfo()) == null) {
            return false;
        }

        if ($this->urlPrefix && strpos($pi, $this->urlPrefix) !== 0) {
            return false;
        }

        if ($this->urlSuffix) {
            $pi = str_replace(".{$this->urlSuffix}", "", $pi);
        }
        $pageAlias = Page::find()
            ->select('alias')
            ->andWhere(['slug' => $pi])
            ->scalar();

        if (!$pageAlias) {
            return false;
        }

        return [$this->route, ['alias' => $pageAlias]];
    }
}