<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_list".
 *
 * @property int $voter_list_id Идентификатор списка избирателей
 * @property int $user_id Идентификатор пользователя
 *
 * @property Users $user
 * @property VotersList $voterList
 */
class UsersList extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['voter_list_id', 'user_id'], 'required'],
            [['voter_list_id', 'user_id'], 'default', 'value' => null],
            [['voter_list_id', 'user_id'], 'integer'],
            [['voter_list_id', 'user_id'], 'unique', 'targetAttribute' => ['voter_list_id', 'user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['voter_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => VotersList::class, 'targetAttribute' => ['voter_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'voter_list_id' => 'Идентификатор списка избирателей',
            'user_id' => 'Идентификатор пользователя',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[VoterList]].
     *
     * @return ActiveQuery
     */
    public function getVoterList(): ActiveQuery
    {
        return $this->hasOne(VotersList::class, ['id' => 'voter_list_id']);
    }
}
