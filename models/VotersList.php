<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class VotersList extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'voters_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getHiddens(): ActiveQuery
    {
        return $this->hasMany(Hiddens::class, ['id' => 'hidden_id'])->viaTable('hiddens_list', ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[HiddensLists]].
     *
     * @return ActiveQuery
     */
    public function getHiddensLists(): ActiveQuery
    {
        return $this->hasMany(HiddensList::class, ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('users_list', ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[UsersLists]].
     *
     * @return ActiveQuery
     */
    public function getUsersLists(): ActiveQuery
    {
        return $this->hasMany(UsersList::class, ['voter_list_id' => 'id']);
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return ActiveQuery
     */
    public function getVotings(): ActiveQuery
    {
        return $this->hasMany(Votings::class, ['voters_list_id' => 'id']);
    }
}
