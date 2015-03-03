<?php

namespace slider\models;

use yii\db\ActiveQuery;
use \common\base\ActiveRecord;
use common\helpers\Storage;
/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property string $image
 * @property integer $weight
 * @property string $alt
 * @property string $title
 * @property string $url
 * @property string $date_created
 * @property string $date_updated
 */
class Slider extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['weight'], 'integer'],
            [['date_created'], 'safe'],
            [['image'], 'string', 'max' => 50],
            [['alt', 'title'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
            [['date_updated'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'image'         => 'Image',
            'weight'        => 'Weight',
            'alt'           => 'Alt',
            'title'         => 'Title',
            'url'           => 'Url',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    /**
     * @return \common\base\ActiveQuery|SliderQuery|ActiveQuery|\yii\db\ActiveQueryInterface
     */
    public static function find()
    {
        return new SliderQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (empty($this->weight)) {
            $this->weight = 1;
        }

        return true;
    }

    public function getUrlBySize($size = 'small')
    {
        return Storage::getStorageUrlTo("/slider/{$size}/{$this->image}");
    }
}
