<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class Users extends ActiveRecord implements IdentityInterface
{
    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'phone', 'password_hash', 'role_type_id'], 'required'],
            [['role_type_id'], 'default', 'value' => null],
            [['role_type_id'], 'integer'],
            [['name', 'middle_name', 'last_name', 'email', 'phone', 'password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['role_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleTypes::class, 'targetAttribute' => ['role_type_id' => 'id']],
            [['authKey', 'access_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентификтор пользователя',
            'name' => 'Имя пользователя',
            'middle_name' => 'Фамилия пользователя',
            'last_name' => 'Отчество пользователя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'password_hash' => 'Пароль',
            'role_type_id' => 'Роль пользователя',
        ];
    }

    public function getMiddleNameAndInitials(): string
    {
        return $this->middle_name . ' ' . $this->name . ' ' . $this->last_name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByEmail($email): ?Users
    {
        return static::findOne(['email' => $email]);
    }

    public static function findByCode($code): ?Users
    {
        return Users::findOne(['email' => $code]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Поиск пользователя по токену доступа
        $user = Users::findOne(['access_token' => $token]);
        if ($user !== null) {
            return $user;
        }

//        // Поиск скрытого пользователя по токену доступа
//        $hiddenUser = Hiddens::findOne(['access_token' => $token]);
//        if ($hiddenUser !== null) {
//            return $hiddenUser;
//        }

        // Если пользователь не найден, возвращаем null
        return null;
    }

    public function getRole(): string
    {
        if ($this->roleType->title == 'Администратор')
            $this->role = 'admin';
        elseif ($this->role_type_id = 3) $this->role = 'hidden';
        else $this->role = 'user';
        return $this->role;
    }

    /**
     * Gets query for [[RoleType]].
     *
     * @return ActiveQuery
     */
    public function getRoleType(): ActiveQuery
    {
        return $this->hasOne(RoleTypes::class, ['id' => 'role_type_id']);
    }

    /**
     * Gets query for [[UsersLists]].
     *
     * @return ActiveQuery
     */
    public function getUsersLists(): ActiveQuery
    {
        return $this->hasMany(UsersList::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[VoterLists]].
     *
     * @return ActiveQuery
     */
    public function getVoterLists(): ActiveQuery
    {
        return $this->hasMany(VotersList::class, ['id' => 'voter_list_id'])->viaTable('users_list', ['user_id' => 'id']);
    }
}
