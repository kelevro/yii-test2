<?php

namespace product\search;


use yii\base\Model;

/**
 * general search model
 */
class GeneralSearch extends Model
{

    public $s;

    public $page;

    public $pageSize;


    public function rules()
    {
        return [
            ['s', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }



    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return json_encode($this->getAttributes());
    }

    public function getUrlParams()
    {
        $us = $this->getAttributes($this->attributes());
        if ($us['page'] > 0) {
            $us['page']--;
        }
        return $us;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        if ($values = @json_decode($serialized, true)) {
            $this->setAttributes($values, false);
        }
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5(json_encode($this->getAttributes(parent::attributes())));
    }

}
