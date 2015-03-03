<?php

namespace user\models\auth;

use common\helpers\ArrayHelper;
use yii\db\Query;
use Yii;

/**
 * RBAC Auth Item Model
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $biz_rule
 * @property string $data
 */
class Item extends \common\base\ActiveRecord
{
    const OPERATION = 0;
    const TASK = 1;
    const ROLE = 2;

    /**
     * @var \yii\rbac\Item
     */
    private $_item;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->_item = new \yii\rbac\Item;
        $this->_item->manager = \Yii::$app->authManager;
    }


    /**
     * @return array
     */
    public static function types()
    {
        return [self::OPERATION => 'Operation', self::TASK => 'Task', self::ROLE => 'Role'];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['description', 'biz_rule', 'data'], 'string'],
            [['name'], 'string', 'max' => 64]
        ];
    }


    /**
     * @return array name => name of assigned child to item
     */
    public function getAssignedChildren()
    {
        return ArrayHelper::map($this->_item->getChildren(), 'name', 'name');
    }

    /**
     * @return array name => name of not assigned child to this item
     */
    public function getNotAssignedChildren()
    {
        $items = (new Query)
            ->select('i.name')
            ->from(self::tableName() . ' AS i')
            ->where(['i.type' => $this->type - 1])
            ->andWhere('name NOT IN (SELECT child FROM auth_item_child WHERE parent = :name)', [':name' => $this->name])
            ->column();
        return array_combine($items, $items);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'biz_rule' => 'Biz Rule',
            'data' => 'Data',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->data = unserialize($this->data);

        $this->_item = \Yii::$app->authManager->getItem($this->name);
    }

    public function save($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        if ($this->isNewRecord) {
            \Yii::$app->authManager->createItem($this->name, $this->type, $this->description, $this->biz_rule, $this->data);
        } else {
            $item = $this->_item;
            $item->name = $this->name;
            $item->type = $this->type;
            $item->description = $this->description;
            $item->bizRule = $this->biz_rule;
            $item->data = $this->data;

            $item->save();
        }
        return true;
    }


    /**
     * @return string title for model type
     */
    public function getTypeTitle()
    {
        return $this->types()[$this->type];
    }


    /**
     * Loads list by type
     *
     * @param string $type
     * @return array
     */
    public static function getListByType($type)
    {
        $items = self::find()
            ->where(['type' => $type])
            ->orderBy('name')
            ->all();
        return \yii\helpers\ArrayHelper::map($items, 'name', 'name');
    }
}
