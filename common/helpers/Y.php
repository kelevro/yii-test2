<?php

/**
 * Shortcuts for Yii functions
 *
 * @package app\common\components
 */
class Y
{
    public static function generateSlug($string, $lengthMax = 50)
    {
        return (string) \common\helpers\Stringy::create($string)->safeTruncate($lengthMax)->slugify();
    }

    /**
     * @param string $sql
     * @return \yii\db\Command
     */
    public static function dbc($sql = null)
    {
        return \Yii::$app->db->createCommand($sql);
    }


    /**
     * Возвращает пользовательский параметр приложения
     * @param string $key Ключ параметра или ключи вложенных параметров через точку
     * Например, 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия ключа
     * @return mixed
     */
    public static function param($key, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($key, Yii::$app->params, $defaultValue);
    }

    /**
     * Return class name without namespace
     *
     * @param object $obj
     * @return string
     */
    public static function getClass($obj)
    {
        $class = get_class($obj);
        $pos = strrpos($class, '\\');
        if ($pos) {
            $pos++;
        }
        return substr($class, $pos);
    }


    /**
     * Возвращает значения ключа в заданном массиве
     * @param string $key Ключ или ключи точку
     * Например, 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @param array $array Массив значений
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия ключа
     * @return mixed
     */
    private static function  _getValueByComplexKeyFromArray($key, $array, $defaultValue = null)
    {
        if (strpos($key, '.') === false) {
            return (isset($array[$key])) ? $array[$key] : $defaultValue;
        }

        $keys = explode('.', $key);

        if (!isset($array[$keys[0]])) {
            return $defaultValue;
        }

        $value = $array[$keys[0]];
        unset($keys[0]);

        foreach ($keys as $k) {
            if (!isset($value[$k]) && !array_key_exists($k, $value)) {
                return $defaultValue;
            }
            $value = $value[$k];
        }

        return $value;
    }

    /**
     * Close connection to database
     */
    public static function closeDB()
    {
        \Yii::$app->db->close();
    }

    /**
     * Open connection to database
     */
    public static function openDB()
    {
        \Yii::$app->db->open();
    }


    /**
     * @return \app\common\components\User
     */
    public static function user()
    {
        return \Yii::$app->getUser();
    }


    /**
     * @return \yii\web\Request
     */
    public static function request()
    {
        return \Yii::$app->request;
    }

    /**
     * Редиректит по указанному роуту, если юзер гость
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     */
    public static function redirGuest($route)
    {
        if (Yii::$app->user->getIsGuest()) {
            Yii::$app->getResponse()->redirect(yii\helpers\Html::url($route))->send();
            exit;
        }
    }

    /**
     * Редиректит по указанному роуту, если юзер авторизован
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     */
    public static function redirAuthed($route)
    {
        if (!Yii::$app->user->getIsGuest()) {
            Yii::$app->getResponse()->redirect(yii\helpers\Html::url($route))->send();
            exit;
        }
    }

    public static function db()
    {
        return \Yii::$app->db;
    }

    /**
     * Checks user access for specific item
     *
     * @param string $operation
     * @param array $params
     * @return bool
     */
    public static function hasAccess($operation, $params = [])
    {
        if (\Yii::$app->user->checkAccess('admin')) {
            return true;
        }
        return \Yii::$app->getUser()->checkAccess($operation, $params);
    }

    public static function post($paramName)
    {
        return \Y::request()->post($paramName);
    }

    public static function get($paramName)
    {
        return \Y::request()->getQueryParam($paramName);
    }

    /**
     * @return mixed|\yii\web\Session
     */
    public static function session()
    {
        return \Yii::$app->session;
    }

    /**
     * @return \yii\i18n\Formatter
     */
    public static function format()
    {
        return \Yii::$app->getFormatter();
    }

}