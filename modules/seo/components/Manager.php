<?php


namespace seo\components;

use seo\models\SeoRule;
use yii\base\Component;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\web\View;

/**
 * Seo manager object
 *  internal variables
 *      if first page, var will be replaced to empty string
 *      {page} - int - page number
 *      {pageText} - string - page number with text, russian: "страница 2", "страница 4"
 *      {pageTextWithComa} - string - page number with text and coma space, russian: ", страница 2"
 *
 * @package seo\components
 */
class Manager extends Component
{
    public $title;
    public $metaDesc;
    public $metaKeys;

    /**
     * URL for main page for current page
     * uses for facebook sharing and others
     *
     * @var string
     */
    public $pageImage;

    /**
     * Canonical url for current page
     *
     * @var string
     */
    public $pageUrl;

    /**
     * Open Graph page type
     *
     * @var string
     */
    public $pageType;

    /**
     * URL for link tag with next page
     *
     * @var string
     */
    public $nextPage;

    /**
     * URL for link tag with prev page
     *
     * @var string
     */
    public $prevPage;

    /**
     * Add meta no-index tag
     *
     * @var bool
     */
    public $metaNoIndex = false;


    /**
     * @var SeoRule
     */
    private $_seoRule;

    /**
     * Return seo rule meta attribute
     *
     * @param string $name
     * @return string|null
     */
    public function getMetaAttribute($name)
    {
        if ($rule = $this->getSeoRule()) {
            if (in_array($name, $rule->metaAttributes())) {
                return $rule->{$name};
            }
        }
        return null;
    }

    /**
     * Init listen view events
     */
    public function subscribe()
    {
        \Yii::$app->view->on(View::EVENT_BEGIN_PAGE, [$this, 'process']);
    }

    /**
     * Sets page title and meta keys
     */
    public function process()
    {
        $view = \Yii::$app->view;
        $rule = $this->getSeoRule();
        if ($rule) {
            $view->title = $this->processVars($rule->meta_title);
            $view->registerMetaTag([
                'name'    => 'description',
                'content' => $this->processVars($rule->meta_desc),
            ]);
            $view->registerMetaTag([
                'name'    => 'keywords',
                'content' => $this->generateMetaKeys($this->processVars($rule->meta_title)),
            ]);
        } else {
            $view->title = $this->processVars($this->title);
            $view->registerMetaTag([
                'name'    => 'description',
                'content' => $this->processVars($this->metaDesc),
            ]);
            if ($this->metaKeys === null) {
                $keys = $this->generateMetaKeys($this->processVars($this->title));
            } else {
                $keys = $this->metaKeys;
            }
            $view->registerMetaTag([
                'name'    => 'keywords',
                'content' => $keys,
            ]);
        }

        $this->processMetaTags();
        $this->processSocialTags();
    }

    protected function processMetaTags()
    {
        $view = \Yii::$app->view;
        if ($this->nextPage) {
            $view->registerLinkTag([
                'rel' => 'next',
                'href' => $this->nextPage,
            ]);
        }

        if ($this->prevPage) {
            $view->registerLinkTag([
                'rel' => 'prev',
                'href' => $this->prevPage,
            ]);
        }

        if ($this->metaNoIndex) {
            $view->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);
        }

        if ($this->pageUrl) {
            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => $this->pageUrl,
            ]);
        }
    }

    protected function processSocialTags()
    {
        $view = \Yii::$app->view;
        $view->registerMetaTag([
            'property' => 'og:title',
            'content'  => $view->title,
        ]);

        $view->registerMetaTag([
            'property' => 'fb:admins',
            'content'  => \Y::param('social.facebook.adminUserId'),
        ]);

        $view->registerMetaTag([
            'property' => 'fb:app_id',
            'content'  => \Y::param('social.facebook.appId'),
        ]);

        if ($this->pageType) {
            $view->registerMetaTag([
                'property' => 'og:type',
                'content'  => $this->pageType,
            ]);
        }

        if ($this->pageImage) {
            $view->registerMetaTag([
                'property' => 'og:image',
                'content'  => $this->pageImage,
            ]);
        }

        if ($this->pageUrl) {
            $view->registerMetaTag([
                'property' => 'og:url',
                'content'  => $this->pageUrl,
            ]);
        }
    }


    /**
     * @return SeoRule
     */
    protected function getSeoRule()
    {
        if ($this->_seoRule === null) {
            $this->_seoRule = SeoRule::findByRoute(\Yii::$app->controller->route, $_GET);
        }
        return $this->_seoRule;
    }

    /**
     * Processing variables in string
     *
     * @param string $string
     * @return string
     */
    protected function processVars($string)
    {
        $string = $this->processPage($string);

        return $string;
    }

    protected function processPage($string)
    {
        if (($page = \Y::request()->getQueryParam('page')) == 1) {
            return str_replace(['{page}','{pageText}','{pageTextWithComa}'], '', $string);
        }

        return str_replace([
            '{page}',
            '{pageText}',
            '{pageTextWithComa}'],
            [
                $page,
                'страница '.$page,
                ', страница '.$page,
            ], $string);
    }

    /**
     * Generates meta keys from title
     *
     * @param string $title
     * @return string
     */
    protected function generateMetaKeys($title)
    {
        return (string)\common\helpers\Stringy::create($title)->keys();
    }
}