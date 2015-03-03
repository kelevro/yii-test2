<?php
namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\FrontUser as FrontUserModel;
use yii\base\Exception;

class FrontUser extends Model
{
    /**
     * @var int id of current project
     */
    public $msId;

    public $name;

    public $phone;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Пожалуйста, введите Ваше имя'],
            ['phone', 'required', 'message' => 'Пожалуйста, введите Ваш телефон'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'      => 'Ваше имя',
            'phone'     => 'Ваш телефон'
        ];
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }
        $trans = \Yii::$app->db->beginTransaction();
        try {
            $user = new FrontUserModel;
            $user->name  = $this->name;
            $user->phone = $this->phone;
            $user->ms_id = $this->msId;
            $user->save(false);
            $trans->commit();
            return true;
        } catch (Exception $e) {
            $trans->rollBack();
            return false;
        }

    }
}