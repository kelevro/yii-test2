<?php

namespace mail\models;

/**
 * Model represents mail subscriber
 *
 * @property integer $id
 * @property string $email
 * @property boolean $is_enabled
 * @property string $hash
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_last_sent
 * @property string $date_opened
 *
 */
class Subscriber extends \common\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Введите, пожалуйста, E-Mail'],
            ['email', 'email', 'message' => 'Проверьте правильность E-Mail'],
            ['email', 'unique', 'message' => 'Вы уже подписаны'],
        ];
    }

    /**
     * @return SubscriberQuery
     */
    public static function find()
    {
        return new SubscriberQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'email'          => 'Email',
            'is_enabled'     => 'Is Enabled',
            'date_created'   => 'Date Created',
            'date_updated'   => 'Date Updated',
            'date_last_sent' => 'Date Last Sent',
            'date_opened'    => 'Date Opened',
        ];
    }

    public static function createSimple($email)
    {


        $subscriber              = new self();
        $subscriber->email       = $email;
        $subscriber->is_enabled = 1;
        if (!$subscriber->save()) {
            return false;
        }
        return $subscriber->id;
    }

    /**
     * Find or create subscriber
     *
     * @param $email
     * @return bool|int|mixed
     */
    public static function findByEmail($email)
    {
        if ($subscriber = self::findOne(['email' => $email])) {
            return $subscriber->id;
        }

        return self::createSimple($email);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->hash = substr(md5(uniqid(rand(), true)), 0, 12);
        return true;
    }

    public function disable()
    {
        $this->is_enabled = false;
        $this->save(false, ['is_enabled']);
    }
}
