<?php


namespace seo\sitemap;

use common\components\ms\MultiSite;
use yii\base\Object;


/**
 * Base generator
 *
 * @package seo\sitemap
 */
abstract class BaseGenerator extends Object
{
    public $lastmod;

    public $changefreq = 'weekly';

    public $priority = 0.8;

    /**
     * @var MultiSite
     */
    protected $multisite;

    /**
     * Constructor
     *
     * @param Multisite $multisite
     * @param array $config
     */
    public function __construct($multisite, $config = [])
    {
        $this->multisite = $multisite;

        \Yii::$app->urlManager->setBaseUrl('http://'.$this->multisite->getDomain());

        parent::__construct($config);
    }

    /**
     * Returns files list
     * if generator have only one file, return null
     *
     * can return string array and array of object with addition data,
     * object must has __toString method
     *
     * @return null|array
     */
    public function files()
    {
        return null;
    }

    /**
     * Main query function, yields url
     *
     * @param mixed|null $file optional file object
     * @see files
     */
    public abstract function url($file = null);
}