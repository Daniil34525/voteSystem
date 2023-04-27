<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id Идентификтор пользователя
 * @property string $name Имя пользователя
 * @property string|null $middle_name Фамилия пользователя
 * @property string|null $last_name Отчество пользователя
 * @property string $email E-mail адрес
 * @property string $phone Телефон
 * @property string $password_hash Хеш пароля
 * @property int $role_type_id Роль пользователя
 *
 * @property RoleTypes $roleType
 * @property UsersList[] $usersLists
 * @property VotersList[] $voterLists
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'password_hash', 'role_type_id'], 'required'],
            [['role_type_id'], 'default', 'value' => null],
            [['role_type_id'], 'integer'],
            [['name', 'middle_name', 'last_name', 'email', 'phone', 'password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['role_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleTypes::class, 'targetAttribute' => ['role_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификтор пользователя',
            'name' => 'Имя пользователя',
            'middle_name' => 'Фамилия пользователя',
            'last_name' => 'Отчество пользователя',
            'email' => 'E-mail адрес',
            'phone' => 'Телефон',
            'password_hash' => 'Хеш пароля',
            'role_type_id' => 'Роль пользователя',
        ];
    }

    /**
     * Gets query for [[RoleType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleType()
    {
        return $this->hasOne(RoleTypes::class, ['id' => 'role_type_id']);
    }

    /**
     * Gets query for [[UsersLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersLists()
    {
        return $this->hasMany(UsersList::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[VoterLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoterLists()
    {
        return $this->hasMany(VotersList::class, ['id' => 'voter_list_id'])->viaTable('users_list', ['user_id' => 'id']);
    }
}
