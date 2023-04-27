<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_list".
 *
 * @property int $voter_list_id Идентификатор списка избирателей
 * @property int $user_id Идентификатор пользователя
 *
 * @property Users $user
 * @property VotersList $voterList
 */
class UserList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'voter_list_id' => 'Идентификатор списка избирателей',
            'user_id' => 'Идентификатор пользователя',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[VoterList]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoterList()
    {
        return $this->hasOne(VotersList::class, ['id' => 'voter_list_id']);
    }
}
