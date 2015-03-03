<?php

namespace news\models;

use yii\db\ActiveQuery;
use common\helpers\Storage;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "new".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property boolean $is_enabled
 * @property boolean $is_sended
 * @property string $preview_img
 * @property string $img_title
 * @property string $img_alt
 * @property string $date_created
 * @property string $date_updated
 */
class News extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'slug'], 'string'],
            [['is_enabled', 'is_sended'], 'boolean'],
            [['date_created', 'date_updated'], 'safe'],
            [['title', 'preview_img', 'img_title', 'img_alt'], 'string', 'max' => 255]
        ];
    }

    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'seoData' => [
                'class' => '\seo\behaviors\SeoData',
                'ruleParams' => function() {
                    return ['news/default/view', ['id' => $this->id]];
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'title'         => 'Title',
            'content'       => 'Content',
            'is_enabled'    => 'Is Enabled',
            'preview_img'   => 'Preview Img',
            'date_created'  => 'Date Created',
            'date_updated'  => 'Date Updated',
        ];
    }

    /**
     * @param string $size
     * @return string
     */
    public function getMainPhotoUrlBySize($size = 'big')
    {
        if (empty($this->preview_img)) {
            return false;
        }
        return Storage::getStorageUrlTo("/news/main/{$size}/{$this->preview_img}");
    }
}
