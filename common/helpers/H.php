<?php
use yii\base\Exception;

/**
 * Вспомогательные функции
 */
class H
{

    /**
     * Задание сида для генератора рандомных чисел
     *
     * @static var bool $thisProcessHasBeenInitialized
     * @return void
     */
    public static function randomizeProcessSeed()
    {
        static $thisProcessHasBeenInitialized;

        if ($thisProcessHasBeenInitialized) {
            return;
        }

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((10000000000 * (float)$usec) ^ (float)$sec);

        $thisProcessHasBeenInitialized = true;
    }

    /**
     * Генерация рандомных строк
     *
     * @param int $len
     * @param string $type
     * @return string
     */
    public static function generateRandomString($len = 32, $type = "default")
    {
        self::randomizeProcessSeed();
        $randomText = null;
        for ($i = 0; $i < $len; $i++) {
            $temp = mt_rand(1, 3);
            if ($i == 0 and $type == "var") {
                $temp2 = mt_rand(1, 2);
                if ($temp2 == 1) {
                    $randomText .= chr(mt_rand(65, 90));
                } else {
                    $randomText .= chr(mt_rand(97, 122));
                }
            } else {
                if ($temp == 1) {
                    $randomText .= chr(mt_rand(65, 90));
                } elseif ($temp == 2) {
                    $randomText .= chr(mt_rand(97, 122));
                } else {
                    $randomText .= chr(mt_rand(48, 57));
                }
            }
        }
        return $randomText;
    }

    public static function calculateSize($size, $sep = ' ')
    {
        $unit = null;
        $units = array('байт', 'КБ', 'МБ', 'ГБ', 'ТБ');

        for ($i = 0, $c = count($units); $i < $c; $i++) {
            if ($size > 1024) {
                $size = $size / 1024;
            } else {
                $unit = $units[$i];
                break;
            }
        }

        return round($size, 2) . $sep . $unit;
    }

    public static function generateFileName()
    {
        return md5(self::generateRandomString() . 'jaja!!!' . time());
    }


    public static function sqldate($timestamp = null)
    {
        $format = "Y-m-d H:i:s";
        return (empty($timestamp)) ? date($format) : date($format, $timestamp);
    }

    /**
     * Return directory for file depents of it file type
     *
     * @static
     * @param string|null $fileType
     * @return string
     * @throws Exception
     */
    public static function getStoragePath($fileType = null)
    {
        $storage = \Yii::getAlias('@app/'.APP_TYPE.'/web/storage');
        if ($fileType) {
            $storage .= DS . strtolower($fileType);
        }

        if (!file_exists($storage) && !@mkdir($storage, 0777, true)) {
            throw new Exception("Unable to create directory '{$storage}'");
        }

        return $storage;
    }

    /**
     * Return url to storage directory for file type
     *
     * @param string|null $fileType
     * @return string
     */
    public static function getStorageUrl($fileType = null)
    {
        $url = '/storage/';
        if ($fileType) {
            $url .= $fileType . '/';
        }

        return $url;
    }

    public static function getDaysCount($date1, $date2)
    {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%M-%d %H:%i');
    }
}
