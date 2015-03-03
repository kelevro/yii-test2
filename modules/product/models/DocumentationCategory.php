<?php

namespace product\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "documentation_category".
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $date_created
 *
 * @property Documentation[] $documentations
 */
class DocumentationCategory extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documentation_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['date_created'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 100]
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
            'slug'          => 'Slug',
            'date_created'  => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentations()
    {
        return $this->hasMany(Documentation::className(), ['category_id' => 'id']);
    }

    public static function getRecordsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
