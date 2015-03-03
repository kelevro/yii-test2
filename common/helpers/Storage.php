<?php


namespace common\helpers;

use yii\helpers\FileHelper;

/**
 * Helper methods for work with content storage
 *
 * @package common\helpers
 */
class Storage
{
    /**
     * @return string full path to storage dir
     */
    public static function getStoragePath()
    {
        return \Yii::getAlias('@storage');
    }

    /**
     * @return string root url to storage domain
     */
    public static function getStorageUrl()
    {
        return 'http://'.\Y::param('domains.storage');
    }


    /**
     * Get path to subdirectory in storage
     *
     * @param string $subPath
     * @param bool $create
     * @return string
     * @throws
     */
    public static function getStoragePathTo($subPath, $create = true)
    {
        $path = str_replace('//', '/', self::getStoragePath().'/'.$subPath.'/');
        if ($create && !FileHelper::createDirectory($path)) {
            throw new \common\base\Exception("Unable to create directory '$path'");
        }
        return $path;
    }

    /**
     * Get full url to subpath in storage
     *
     * @param string $subPath
     * @return string
     */
    public static function getStorageUrlTo($subPath)
    {
        return self::replaceDoubleSlashInUrl(self::getStorageUrl().'/'.$subPath);
    }

    protected static function replaceDoubleSlashInUrl($url)
    {
        return str_replace('http:/', 'http://', preg_replace('/\/\//', '/', $url));
    }
}