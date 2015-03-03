<?php

namespace product\models\forms;

use product\models\Attribute;
use yii\base\Model;
use yii\helpers\Json;

class AttributeUpdate extends Model
{

    /**
     * @var Attribute
     */
    public $attr;

    /**
     * @var string attr title
     */
    public $title;

    /**
     * @var boolean
     */
    public $is_selectable;

    /**
     * @var array attr categories ids
     */
    public $category;

    public $values = [];

    public $filters = [];



    public function __construct(Attribute $attr, $config = [])
    {
        parent::__construct($config);

        $this->attr = $attr;
        if ($this->attr->isNewRecord) {
            $this->attr->is_selectable = 0;
        }

        $this->title            = $this->attr->title;
        $this->category         = $this->attr->category_id;
        $this->is_selectable    = $this->attr->is_selectable;
        if ($this->is_selectable && $this->attr->data) {
            $this->values = Json::decode($this->attr->data);
        }

        if ($this->attr->filters) {
            $this->filters = Json::decode($this->attr->filters);
        }
    }

    public function rules()
    {
        return [
            [['title', 'category'], 'required'],
            ['is_selectable', 'boolean'],
            [['values', 'filters'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'is_selectable' => 'Attribute Type'
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

        return true;
    }


    /**
     * Save club
     *
     * @param bool $validate
     * @return bool|int attr id
     * @throws
     */
    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $trans = \Yii::$app->db->beginTransaction();
        try {
            $attr = $this->attr;


            $attr->title            = $this->title;
            $attr->category_id      = (integer) $this->category;
            $attr->is_selectable    = $this->is_selectable;
            if ($attr->is_selectable && $this->values) {
                $this->attr->data    = Json::encode(array_values($this->values));
                $this->attr->filters = Json::encode(array_values($this->values));
            } else {
                $this->attr->filters = Json::encode(array_values($this->filters));
            }

            $attr->save(false);

            $this->attr = $attr;

            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            throw $e;
        }

        return $attr->id;
    }
}