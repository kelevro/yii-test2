<?php


namespace seo\sitemap;

use common\components\ms\MultiSite;
use seo\Exception;
use yii\base\Component;
use yii\helpers\FileHelper;

class Generator extends Component
{
    const FLUSH_SIZE = 100;

    public $log = 'sitemap-generator';

    /**
     * @var string webroot directory
     */
    public $webroot = '@frontend/web/';

    public $subDir = 'sitemaps';

    /**
     * @var string name of index sitemap
     */
    public $indexSitemap = 'sitemap.xml';

    /**
     * List of generator classes
     *  'alias' => 'class'
     *
     * @var array
     */
    public $generators;

    /**
     * @var MultiSite
     */
    protected $multiSite;

    protected $domain;

    private $_tempDir;

    /**
     * Creates new temp directory and return it full path
     *
     * @return string
     */
    protected function getTempDir()
    {
        if ($this->_tempDir == null) {
            $dir = \Yii::$app->runtimePath.DS.'sitemap-'.date('Ymd-his');
            if (!mkdir($dir, 0777, true)) {
                throw new Exception("Unable to create temp directory '{$dir}' for sitemap");
            }
            $this->_tempDir = $dir;
        }
        return $this->_tempDir;
    }


    /**
     * Starts process
     */
    public function generate($multiSiteId)
    {
        \Y::msManager()->setActive($multiSiteId);
        $this->multiSite = \Y::msManager()->findMultiSite($multiSiteId);
        $this->domain = $this->multiSite->getDomain();
        $this->_tempDir = null;

        \L::trace('Starting work', $this->log, __METHOD__);

        $this->generateFiles();

        $this->generateIndex();

        $this->publish();

        $this->removeTempDir();

        \L::trace('All done', $this->log, __METHOD__);
    }

    /**
     * @return \XMLWriter
     */
    private function startXml()
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();

        $xmlWriter->setIndentString('    ');
        $xmlWriter->setIndent(true);

        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('urlset');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        return $xmlWriter;
    }


    protected function generateFiles()
    {
        foreach ($this->generators as $alias => $class) {
            \L::trace("Processing {$alias}", $this->log, __METHOD__);
            /** @var BaseGenerator $generator */
            $generator = \Yii::createObject($class, $this->multiSite);

            if (($files = $generator->files()) == null) {
                $files = [''];
            }

            foreach ($files as $file) {
                $xmlWriter = $this->startXml();

                if ($file) {
                    FileHelper::createDirectory($this->getTempDir().DS.$alias);
                    $xmlFile = $this->getTempDir().DS.$alias.DS.$file.'.xml';
                } else {
                    $xmlFile = $this->getTempDir().DS.$alias.'.xml';
                }

                $i = $total = 0;
                foreach ($generator->url($file) as $url) {
                    $i++;$total++;
                    if (is_array($url)) {
                        $lastmod    = !empty($url['lastmod']) ? $url['lastmod'] : $generator->lastmod;
                        $changefreq = !empty($url['changefreq']) ? $url['changefreq'] : $generator->changefreq;
                        $priority   = !empty($url['priority']) ? $url['priority'] : $generator->priority;
                        $url = $url['url'];
                    } else {
                        $lastmod    = $generator->lastmod;
                        $changefreq = $generator->changefreq;
                        $priority   = $generator->priority;
                    }
                    $xmlWriter->startElement('url');
                    $xmlWriter->writeElement('loc', $url);
                    $xmlWriter->writeElement('lastmod', $lastmod);
                    $xmlWriter->writeElement('changefreq', $changefreq);
                    $xmlWriter->writeElement('priority', $priority);
                    $xmlWriter->endElement();

                    if ($i >= self::FLUSH_SIZE) {
                        file_put_contents($xmlFile, $xmlWriter->flush(), FILE_APPEND);
                        $i = 0;
                    }
                }
                $xmlWriter->endElement();
                file_put_contents($xmlFile, $xmlWriter->flush(), FILE_APPEND);
                $f = $file ? $alias.'/'.$file : $alias;
                \L::success("Wrote {$total} urls to {$f} xml", $this->log, __METHOD__);
            }
        }
    }

    public function generateIndex()
    {
        \L::trace('Starting generate index sitemap', $this->log, __METHOD__);
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();

        $xmlWriter->setIndentString('    ');
        $xmlWriter->setIndent(true);

        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('sitemapindex');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->generators as $alias => $config) {
            /** @var BaseGenerator $generator */
            $generator = \Yii::createObject($config, $this->multiSite);
            if (($files = $generator->files()) == null) {
                $files = [''];
            }

            foreach ($files as $file) {
                if ($file) {
                    $xmlFile = $alias.'/'.$file;
                } else {
                    $xmlFile = $alias;
                }
                $loc = 'http://' . $this->domain . '/' . $this->subDir . '/' . $this->multiSite->getAlias() . '/' . $xmlFile . '.xml';
                $xmlWriter->startElement('sitemap');
                $xmlWriter->writeElement('loc', $loc);
                $xmlWriter->writeElement('lastmod', date('Y-m-d'));
                $xmlWriter->endElement();
            }
        }
        $xmlWriter->endElement();
        file_put_contents($this->getTempDir().DS.$this->indexSitemap, $xmlWriter->flush(), FILE_APPEND);
        \L::trace('Completed', $this->log, __METHOD__);
    }

    /**
     * Moves generated files to webroot directory
     */
    protected function publish()
    {
        \L::trace('Staring publishing sitemaps', $this->log, __METHOD__);

        $root = \Yii::getAlias($this->webroot . $this->subDir .DS. $this->multiSite->getAlias());

        \L::trace('Removing exists files', $this->log, __METHOD__);
        $i = 0;
        foreach (glob($root.'/*') as $file) {
            if (is_dir($file)) {
                FileHelper::removeDirectory($file);
            } else {
                unlink($file);
            }
            $i++;
        }
        \L::success("Removed {$i} files", $this->log, __METHOD__);

        \L::trace('Moving...', $this->log, __METHOD__);
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        foreach ($this->generators as $alias => $config) {
            /** @var BaseGenerator $generator */
            $generator = \Yii::createObject($config, $this->multiSite);
            if (($files = $generator->files()) == null) {
                $files = [''];
            }

            foreach ($files as $file) {
                if ($file) {
                    FileHelper::createDirectory($root.DS.$alias);
                    $xmlFile = $alias.DS.$file;
                } else {
                    $xmlFile = $alias;
                }
                rename($this->getTempDir().DS.$xmlFile.'.xml', $root.DS.$xmlFile.'.xml');
            }
        }
        rename($this->getTempDir().DS.$this->indexSitemap, $root.DS.$this->indexSitemap);

        \L::success('All operations completed', $this->log, __METHOD__);
    }

    protected function removeTempDir()
    {
        FileHelper::removeDirectory($this->getTempDir());
        \L::success("Successfully removed temp directory '{$this->getTempDir()}'", $this->log, __METHOD__);
    }
}
