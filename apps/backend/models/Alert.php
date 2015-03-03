<?php

namespace backend\models;
use common\helpers\Stringy;

/**
 * Alert model
 *
 * @property string $id
 * @property string $project_id
 * @property string $type
 * @property string $from
 * @property string $message
 * @property string $date_created
 */
class Alert extends \common\base\ActiveRecord
{
    const TYPE_WARNING = 'warning';
    const TYPE_NOTICE = 'notice';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'alert';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['type', 'message'], 'string'],
			[['message'], 'required'],
			[['from'], 'string', 'max' => 50]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
            'id'           => 'ID',
            'project_id'   => 'Project ID',
            'type'         => 'Type',
            'from'         => 'From',
            'message'      => 'Message',
            'date_created' => 'Date Created',
		];
	}

    /**
     * Return message preview
     *
     * @param int $length
     * @return string
     */
    public function getMessagePreview($length = 100)
    {
        return (string)Stringy::create($this->message)->safeTruncate($length, '...');
    }
}
