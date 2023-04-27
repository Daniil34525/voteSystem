<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voters_list".
 *
 * @property int $id Идентификатор списка избирателей
 * @property int $created_at Время создания списка
 * @property int|null $updated_at Время обновления списка
 *
 * @property Hiddens[] $hiddens
 * @property HiddensList[] $hiddensLists
 * @property Users[] $users
 * @property UsersList[] $usersLists
 * @property Votings[] $votings
 */
class VotersList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voters_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор списка избирателей',
            'created_at' => 'Время создания списка',
            'updated_at' => 'Время обновления списка',
        ];
    }

    /**
     * Gets query for [[Hiddens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHiddens()
    {
        return $this->hasMany(Hiddens::class, ['id' => 'hidden_id'])->viaTable('hiddens_list', ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[HiddensLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHiddensLists()
    {
        return $this->hasMany(HiddensList::class, ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('users_list', ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[UsersLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersLists()
    {
        return $this->hasMany(UsersList::class, ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotings()
    {
        return $this->hasMany(Votings::class, ['voters_list_id' => 'id']);
    }
}
