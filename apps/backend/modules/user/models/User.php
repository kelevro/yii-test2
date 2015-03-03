<?php

namespace user\models;

use common\base\ActiveRecord;
use yii\base\Security;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;
use common\helpers\Storage;
use yii\web\UploadedFile;

/**
 * Model for backend user
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password_hash
 * @property string $is_deleted
 * @property string $sex
 * @property string $signature
 * @property string $auth_key
 * @property boolean $has_photo
 * @property string $photo
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 * @property string $date_last_login
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const MALE      = 'male';
    const FEMALE    = 'female';

    public $password;

    protected $_roles;

    /** @var  UploadedFile */
    public $filePhoto;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backend_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'min' => 2, 'max' => 100],
            ['has_photo', 'boolean', 'on' => 'admin'],
            ['photo',     'string',  'on' => 'admin'],

            ['password', 'string', 'min' => 6],

            ['filePhoto', 'file', 'extensions' => ['png', 'jpg'], 'on' => 'admin'],

            ['sex', 'in', 'range' => [self::MALE, self::FEMALE], 'message' => 'Incorrect sex','on' => 'admin'],

            ['signature', 'string', 'max' => 150, 'on' => 'admin'],

            [['first_name', 'last_name'], 'string', 'max' => 50, 'on' => 'admin'],
            ['is_deleted', 'boolean', 'on' => 'admin'],
            ['roles', 'validateRoles', 'on' => 'admin'],
        );
    }

    public static function getSexList()
    {
        return ['male' => 'Мужской', 'female' =>'Женский'];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->filePhoto = UploadedFile::getInstance($this, 'filePhoto');
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'project_id'      => 'Project ID',
            'email'           => 'Email',
            'is_deleted'      => 'User deleted',
            'password'        => 'Password',
            'date_created'    => 'Date Created',
            'date_updated'    => 'Date Updated',
            'date_last_login' => 'Date Last Login',
        ];
    }

    /**
     * @return UserQuery|ActiveQuery|\yii\db\ActiveQueryInterface
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return null|User
     */
    public static function findByEmail($email)
    {
        return static::findOne(array('email' => $email, 'is_deleted' => 0));
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        if ($this->is_deleted) {
            return false;
        }
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds an identity by the given secrete token.
     * @param string $token the secrete token
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        dd('findIdentityByAccessToken');
        // TODO: Implement findIdentityByAccessToken() method.
    }


    /**
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->is_deleted) {
            return false;
        }
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function scenarios()
    {
        return [
            'default' => ['email', 'password'],
            'admin'   => ['first_name', 'last_name', 'email', 'password', 'is_deleted',
                          'roles', 'sex', 'signature', 'has_photo', 'filePhoto'],
        ];
    }

    protected function getRoles()
    {
        if ($this->_roles === null) {
            $this->_roles = $this->getAssignedRoles();
        }
        return $this->_roles;
    }

    protected function setRoles($roles)
    {
        $this->_roles = $roles;
    }


    public function validateRoles()
    {
        if ($this->getRoles() === null) {
            return;
        }
        $roles = $this->getAvailableRoles();
        foreach ($this->getRoles() as $role) {
            if (!in_array($role, $roles)) {
                $this->addError('roles', 'Incorrect role '.$role);
            }
        }
    }

    /**
     * @return array assigned roles to user
     */
    public function getAssignedRoles()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles($this->id), 'name', 'name');
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (($this->isNewRecord || $this->scenario == 'admin') && !empty($this->password)) {
                $this->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->getSecurity()->generateRandomKey();
            }

            $deleted = $this->getDirtyAttributes(['is_deleted']);
            if (!$this->isNewRecord && !empty($deleted['is_deleted']) && $this->is_deleted) {
                $this->date_deleted = new Expression('NOW()');
                $this->password_hash = 'deleted';
                $this->auth_key = 'deleted';

                $this->setRoles([]);

                // we cant undelete user
                if ($deleted['is_deleted'] == 0) {
                    $this->is_deleted = 1;
                }
            }

            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->scenario != 'admin') {
            return true;
        }

        $roles = $this->getRoles() ?: [];

        $wasAssigned = $this->isNewRecord ? [] : $this->getAssignedRoles();
        $removed = array_diff($wasAssigned, $roles);
        foreach ($roles as $role) {
            if (!in_array($role, $wasAssigned)) {
                \Yii::$app->authManager->assign($this->id, $role);
            }
        }
        foreach ($removed as $role) {
            \Yii::$app->authManager->revoke($this->id, $role);
        }

        if (!empty($this->filePhoto) && $this->filePhoto instanceof UploadedFile) {
            if (
            $this->filePhoto->saveAs(Storage::getStoragePathTo(\Y::param('user.avatar.origin_path'))
                . $this->getPhotoName())
            ) {
                $this->has_photo = 1;
                $this->save(false, ['has_photo']);
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();

        foreach ($this->getAssignedRoles() as $role) {
            \Yii::$app->authManager->revoke($this->id, $role);
        }
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return ['admin' => self::OP_ALL];
    }

    /**
     * Updates user last login date
     */
    public function updateLoginDate()
    {
        $this->date_last_login = new Expression('NOW()');
        $this->save(false, ['date_last_login']);
    }

    /**
     * @return array list of available roles
     */
    public function getAvailableRoles()
    {
        return (in_array('content-editor', \Y::user()->role))
            ? ['content-copywriter' => 'content-copywriter']
            : ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'name');
    }

    /**
     * Return list with users only has right
     *
     * @param string|null $right
     * @return User[]
     */
    public static function getUsersByRight($right = null)
    {
        /** @var User[] $users */
        $users = static::find()->active()->all();

        $list = [];
        foreach ($users as $user) {
            if (\Yii::$app->authManager->checkAccess($user->id, $right)) {
                $list[] = $user;
            }
        }

        return $list;
    }

    /**
     * @return string user first name and last name or email
     */
    public function getTitle()
    {
        if ($this->first_name || $this->last_name) {
           return $this->getUserName();
        } else {
            return $this->email;
        }
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getIsMan()
    {
        return $this->sex == self::MALE;
    }

    // TODO: передать функции с фото нахрен, хер поймешь для чего каждая

    public function getPhoto()
    {
        if (!$this->has_photo) {
            return null;
        }
        return $this->getPhotoName();
    }

    public function getPhotoUrl()
    {
        if (!$this->photo) {
            return null;
        }

        return Storage::getStorageUrlTo(\Y::param('user.avatar.origin_path')) . $this->photo;
    }

    public function getPhotoName()
    {
        return $this->id . '.jpg';
    }
}
