<?php

namespace product\models\forms;

use common\helpers\ArrayHelper;
use product\models\Attribute;
use product\models\AttributeValue;
use product\models\Category;
use product\models\Documentation;
use product\models\Image;
use product\models\Product;
use yii\base\Model;
use yii\helpers\Json;

class ProductUpdate extends Model
{

    /**
     * @var \product\models\Product
     */
    public $product;

    /** @var  integer */
    public $priceId;

    /**
     * @var string product title
     */
    public $title;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var bool
     */
    public $is_enabled;

    /**
     * @var string
     */
    public $description;

    public $wholesale;

    public $small_wholesale;

    public $count;

    public $producer;

    /**
     * @var array product categories ids
     */
    public $category;

    /**
     * @var integer
     */
    public $price;

    public $attrs;

    public $filters;

    /** @var array  */
    public $images = [];

    public $documentations;

    public $documentationText;

    public $relatedProducts;

    public $relatedProductsText;


    public function __construct(Product $product, $config = [])
    {
        parent::__construct($config);

        $this->product = $product;

        if ($this->product->isNewRecord) {
            $this->product->is_enabled = true;
        }

        $this->title            = $this->product->title;
        $this->producer         = $this->product->producer;
        $this->wholesale        = ($this->product->wholesale)?:0;
        $this->small_wholesale  = ($this->product->small_wholesale)?:0;
        $this->count            = ($this->product->count)?:0;
        $this->slug             = $this->product->slug;
        $this->priceId          = $this->product->price_id;
        $this->category         = $this->product->category_id;
        $this->description      = $this->product->description;
        $this->is_enabled       = $this->product->is_enabled;
        $this->price            = ($this->product->price)?:0;
        $this->documentations   = ArrayHelper::map($this->product->findRelatedDocumentations(), 'id', 'link');
        $this->relatedProducts  = ArrayHelper::map($this->product->relatedProducts, 'id', 'title');
    }

    public function rules()
    {
        return [
            [['title', 'slug', 'price', 'category'], 'required'],
            ['is_enabled', 'boolean'],
            [['priceId'], 'integer'],
            [['wholesale', 'small_wholesale',], 'number'],
            [['description', 'attrs', 'images', 'filters', 'documentationText', 'documentations',
            'relatedProducts', 'relatedProductsText', 'producer', 'count',], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'is_enabled'            => 'Enabled',
            'documentation_id'      => 'Documentation',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        return $this->product->validateSeoData();
    }


    /**
     * Save club
     *
     * @param bool $validate
     * @return bool|int product id
     * @throws
     */
    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $this->documentations  = array_filter(explode(',', $this->documentationText));
        $this->relatedProducts = array_filter(explode(',', $this->relatedProductsText));

        $trans = \Yii::$app->db->beginTransaction();
        try {
            $product = $this->product;


            $product->title             = $this->title;
            $product->producer          = $this->producer;
            $product->wholesale         = $this->wholesale;
            $product->small_wholesale   = $this->small_wholesale;
            $product->count             = $this->count;
            $product->slug              = $this->slug;
            $product->category_id       = (integer) $this->category;
            $product->is_enabled        = $this->is_enabled;
            $product->description       = $this->description;
            $product->price             = $this->price;

            $product->save(false);

            $this->product = $product;

            $this->processAttributes();
            $this->processImages();
            $this->processDocumentations();
            $this->processRelatedProducts();

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            throw $e;
        }

        return $product->id;
    }

    /**
     * Work on job categories relations
     */
    protected function processDocumentations()
    {
        $exists = $this->product->isNewRecord
            ? []
            : ArrayHelper::getColumn($this->product->getDocumentations()->all(), 'id');

        $removed = array_diff($exists, $this->documentations);
        $added   = array_diff($this->documentations, $exists);

        foreach (array_filter($removed) as $id) {
            $this->product->unlink('documentations', Documentation::findOne($id), true);
        }
        foreach (array_filter($added) as $id) {
            $this->product->link('documentations', Documentation::findOne($id));
        }
    }

    /**
     * Work on job categories relations
     */
    protected function processRelatedProducts()
    {
        $exists = $this->product->isNewRecord
            ? []
            : ArrayHelper::getColumn($this->product->getRelatedProducts()->all(), 'id');

        $removed = array_diff($exists, $this->relatedProducts);
        $added   = array_diff($this->relatedProducts, $exists);

        foreach (array_filter($removed) as $id) {
            $this->product->unlink('relatedProducts', Product::findOne($id), true);
        }
        foreach (array_filter($added) as $id) {
            $this->product->link('relatedProducts', Product::findOne($id));
        }
    }

    protected function processImages()
    {
        if (!$this->images) {
            return false;
        }
        $imageIds   = array_keys($this->images);
        $exists     = ArrayHelper::getColumn($this->product->getImages()->all(), 'id');
        $removed    = array_diff($exists, $imageIds);
        $added      = array_diff($imageIds, $removed);
        Image::deleteAll(['product_id' => $removed]);
        foreach ($this->images as $id => $image) {
            if (in_array($id, $added)) {
                $image  = Json::decode($image);
                if ($img = Image::findOne($id)) {
                    $img->title         = $image['title'];
                    $img->alt           = $image['alt'];
                    $img->product_id    = $this->product->id;
                    $img->save(false, ['product_id', 'title', 'alt']);
                }
            }
        }

        return true;
    }

    /**
     * Work on images
     */
    protected function processAttributes()
    {
        $filter = null;
        if (!$this->attrs) {
            return false;
        }
        $category = Category::findOne($this->category)->ancestors()->select('id')->column();
        /** @var Attribute[] $attributes */
        $attributes = Attribute::find()->category(array_merge($category, [$this->category]))->all();

        foreach ($attributes as $attr) {
            if (isset($this->filters[$attr->id])) {
                $filterVal = $this->filters[$attr->id];
            } else {
                $filterVal = '';
            }
            if ($attr->is_selectable) {
                $filterVal = $this->attrs[$attr->id];
            }

            if (isset($this->attrs[$attr->id])) {
                $attrVal = $this->attrs[$attr->id];
            } else {
                $attrVal = '';
            }

            AttributeValue::addValue($this->product->id, $attr->id, $attrVal, $filterVal);
        }

        return true;
    }

    public function load($data, $formName = null)
    {
        if (!parent::load($data)) {
            return false;
        }

        $this->product->load($data);

        return true;
    }


    public function getFormAttributes()
    {
        $result = [];
        $category = Category::findOne($this->category)->ancestors()->select('id')->column();
        /** @var Attribute[] $attributes */
        $attributes = Attribute::find()->category(array_merge($category, [$this->category]))->all();

        if (!$attributes) {
            return null;
        }

        foreach ($attributes as $attr) {
            $result[$attr->id] = [
                'title'         => $attr->title,
                'is_selectable' => $attr->is_selectable,
                'values'        => $attr->values,
                'value'         => '',
            ];
        }

        if ($this->product->isNewRecord ) {
            return $result;
        }
        $attrValues = ArrayHelper::map(AttributeValue::find()->product($this->product->id)->all(), 'attribute_id', 'value');
        if ($attrValues) {
            foreach ($attrValues as $attrId => $value) {
                if (isset($result[$attrId])) {
                    $result[$attrId]['value'] = $value;
                }
            }
        }

        return $result;
    }

    public function getAttributeFilter($attrId)
    {
        $result = [];
        $attr = Attribute::findOne($attrId);

        if (!$attr->filterValues) {
            return null;
        }

        $result['filters']      = $attr->filterValues;
        $result['currentValue'] = null;

        if ($this->product->isNewRecord ) {
            return  $result;
        }

        $filterValue = AttributeValue::find()->product($this->product->id)->attr($attrId)->one();

        if ($filterValue && array_key_exists($filterValue['filter'], $result['filters'])) {
            $result['currentValue'] = $filterValue['filter'];
        }

        return $result;
    }
}