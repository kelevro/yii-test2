<?php

namespace common\base;

use yii\db\Expression;

/**
 * Base Active Record for all project models
 *
 * @package common\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Name of updated date column
     *
     * @var string
     */
    protected $updatedColumn = 'date_updated';

    /**
     * Use automatic update date values for fields
     * updatedColumn
     *
     * @var bool
     */
    protected $updateDates = true;

    /**
     * Automatic set null value into string fields
     * when string value is empty
     *
     * @var bool
     */
    protected $ensureNull = true;

    /**
     * Automatic set null value on update record
     * into string fields when string value is empty
     *
     * @var bool
     */
    protected $ensureNullOnUpdate = true;


    /**
     * @return ActiveQuery|\yii\db\ActiveQuery|\yii\db\ActiveQueryInterface
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->updateDates) {
            $this->processUpdateField();
        }

        if ($this->ensureNull && (!$this->ensureNullOnUpdate && !$this->getIsNewRecord())) {
            $this->ensureNull();
        }

        return true;
    }

    private function processUpdateField()
    {
        if (!$this->getIsNewRecord() && $this->getTableSchema()->getColumn($this->updatedColumn)) {
            $this->setAttribute($this->updatedColumn, new Expression('NOW()'));
        }
    }

    private function ensureNull()
    {
        foreach ($this->getTableSchema()->columns as $column) {
            if ($column->allowNull && trim($this->getAttribute($column->name)) == '') {
                $this->setAttribute($column->name, null);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if ($this->getBehavior('seoData')) {
            $this->loadSeoData($data);
        }

        return parent::load($data, $formName);
    }
}