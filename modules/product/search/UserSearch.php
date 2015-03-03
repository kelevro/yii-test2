<?php

namespace product\search;


use yii\base\Model;

/**
 * User's search model
 */
class UserSearch extends Model
{
    public $attributes = [];

    public $category;

    public $page;

    public $pageSize;

    public $filters;

    public function rules()
    {
        return [
            ['filters', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }


    /**
     * Returns attributes list by type
     * possible $type values
     *  null|all - all attributes
     *  main - only main, for subscription, ex: region, query, category
     *  addition - addition attributes, ex. period, page
     *
     * @param string $type
     * @return array
     */
    public function attributes($type = null)
    {
        $list = [
            'zipOrCity'  => 'main',
            'searchText' => 'main',
            'category'   => 'main',
            'distance'   => 'main',

            'page'        => 'addition',
        ];

        if ($type === null || $type == 'all') {
            return array_keys($list);
        } else {
            $items = [];
            foreach ($list as $attr => $aType) {
                if ($aType == $type) {
                    $items[] = $attr;
                }
            }
            return $items;
        }
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return json_encode($this->getAttributes($this->attributes('main')));
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
