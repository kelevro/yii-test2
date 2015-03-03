<?php


namespace news\urls;

use yii\base\Exception;
use news\models\News;
use yii\caching\GroupDependency;
use yii\web\UrlRule;

/**
 * Content article url rule
 *
 * @package content\urls
 */
class NewRule extends UrlRule
{
    /**
     * @var string
     */
    public $urlPrefix = 'news/';


    /**
     * @var string
     */
    public $route = 'news/default/view';

    /**
     * Route for redirect
     * for case when article id has new slug
     *
     * @var string
     */
    public $redirectRoute = 'news/default/new-redirect';

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

        if (empty($params['new'])) {
            throw new Exception("No required param 'new'");
        }

        if (is_numeric($params['new'])) { // article by id
            $newData = News::find()
                ->select('id, slug')
                ->andWhere(['id' => $params['new']])
                ->asArray()
                ->one();
            if ($newData == null) {
                throw new Exception("New #{$params['new']} is not found");
            }
        } else if (is_array($params['new'])) { // article id
            $newData = $params['new'];
            if (empty($newData['id']) || empty($newData['slug'])) {
                throw new Exception('New array must has two elements: id, slug');
            }
        } else if ($params['new'] instanceof News) { // article model
            if ($params['new']->getIsNewRecord()) {
                throw new Exception('New model instance must be saved');
            }
            $newData = $params['new']->attributes;
        } else {
            throw new Exception("Unknown 'article' input param");
        }
        unset($params['new']);

        $url = 'n'.$newData['id'].'-'.$newData['slug'];
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

        $pi = substr($pi, strlen($this->urlPrefix));

        $sufx = $this->urlSuffix ? '\.'.$this->urlSuffix : null;
        if (!preg_match('/^n(\d+)-(.*)'.$sufx.'$/', $pi, $matches)) {
            return false;
        }
        $id = intval($matches[1]);
        $slug = $matches[2];

        $article = News::find()
            ->select('slug')
            ->andWhere(['id' => $id])
            ->asArray()
            ->one();

        if (!$article) {
            return false;
        }

        if ($slug != $article['slug']) {
            return [$this->redirectRoute, ['new' => $id]];
        }

        return [$this->route, ['new' => $id]];
    }
}