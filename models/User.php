<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $middleName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $passwordHash
 *
 * @property RoleType $roleType
 */
class User extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
            ],
        ];
    }

    public function rules(): array
    {
        return
            [
                [['name', 'password_hash', 'email', 'phone', 'roleType_id', 'created_at'], 'required'],
                ['email', 'email'],
                [['email', 'phone'], 'unique'],
                [['name', 'middle_name', 'last_name', 'email', 'phone', 'password_hash'], 'string'],
                [['id', 'roleType_id', 'created_at'], 'integer']
            ];
    }

    public function attributeLabels(): array
    {
        return
            [
                'id' => 'Id',
                'name' => 'Имя',
                'middle_name' => 'Фамилия',
                'last_name' => 'Отчество',
                'email' => 'Почта',
                'phone' => 'Телефон',
                'password' => 'Пароль',
            ];
    }

    /**
     * @throws Exception
     */
    public function hashPassword()
    {
        $this->passwordHash = Yii::$app->getSecurity()->generatePasswordHash($this->passwordHash);
    }

    /**
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        if($insert) $this->hashPassword();
        return parent::beforeSave($insert);
    }

    public function getRole(): ActiveQuery
    {
        return $this->hasOne(RoleType::class, ['typeRole_id', 'id']);
    }

//    private static $users = [
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];
//
//
//    /**
//     * {@inheritdoc}
//     */
//    public static function findIdentity($id)
//    {
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public static function findIdentityByAccessToken($token, $type = null)
//    {
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
//
//        return null;
//    }
//
//    /**
//     * Finds user by username
//     *
//     * @param string $username
//     * @return static|null
//     */
//    public static function findByUsername($username)
//    {
//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }
//
//        return null;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getAuthKey()
//    {
//        return $this->authKey;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function validateAuthKey($authKey)
//    {
//        return $this->authKey === $authKey;
//    }
//
//    /**
//     * Validates password
//     *
//     * @param string $password password to validate
//     * @return bool if password provided is valid for current user
//     */
//    public function validatePassword($password)
//    {
//        return $this->password === $password;
//    }
}
