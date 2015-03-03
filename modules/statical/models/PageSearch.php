<?php

namespace statical\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use menu\models\MainMenu;

/**
 * PageSearch represents the model behind the search form about Page.
 */
class PageSearch extends Model
{
    public $id;
    public $title;
    public $slug;
    public $content;
    public $is_available;
    public $view_file;
    public $css_file;
    public $date_created;
    public $date_updated;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'slug', 'content', 'view_file', 'css_file', 'date_created', 'date_updated'], 'safe'],
            [['is_available'], 'boolean'],];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'slug'          => 'Slug',
            'content'       => 'Content',
            'is_available'  => 'Is Available',
            'view_file'     => 'View File',
            'css_file'      => 'Css File',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    public function search($params)
    {
        $query = Page::find();
        $dataProvider = new ActiveDataProvider(['query' => $query,]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'slug', true);
        $this->addCondition($query, 'content', true);
        $this->addCondition($query, 'is_available');
        $this->addCondition($query, 'view_file', true);
        $this->addCondition($query, 'css_file', true);
        $this->addCondition($query, 'date_created');
        $this->addCondition($query, 'date_updated');
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }

}
