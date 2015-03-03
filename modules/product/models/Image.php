<?php

namespace product\models;

use common\helpers\Storage;
use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property string $id
 * @property string $product_id
 * @property string $img
 * @property string $extension
 * @property integer $size
 * @property string $title
 * @property string $alt
 *
 * @property Product $product
 */
class Image extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img'], 'required'],
            [['product_id', 'size'], 'integer'],
            [['img', 'title', 'alt', 'extension'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'img' => 'Img',
            'title' => 'Title',
            'alt' => 'Alt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function addValue($productId, $img, $size, $type)
    {
        $image                  = new self;
        $image->product_id      = $productId;
        $image->img             = $img;
        $image->size            = $size;
        $image->extension       = $type;
        $image->save(false);
        return true;
    }

    public function getUrlBySize($size = 'small')
    {
        return Storage::getStorageUrlTo("/product/{$size}/{$this->img}");
    }
}
