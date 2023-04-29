<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hiddens_list".
 *
 * @property int $voter_list_id Идентификатор списка избирателей
 * @property int $hidden_id Голосование
 *
 * @property Hiddens $hidden
 * @property VotersList $voterList
 */
class HiddensList extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'hiddens_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['voter_list_id', 'hidden_id'], 'required'],
            [['voter_list_id', 'hidden_id'], 'default', 'value' => null],
            [['voter_list_id', 'hidden_id'], 'integer'],
            [['voter_list_id', 'hidden_id'], 'unique', 'targetAttribute' => ['voter_list_id', 'hidden_id']],
            [['hidden_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hiddens::class, 'targetAttribute' => ['hidden_id' => 'id']],
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
            'hidden_id' => 'Голосование',
        ];
    }

    /**
     * Gets query for [[Hiddens]].
     *
     * @return ActiveQuery
     */
    public function getHidden(): ActiveQuery
    {
        return $this->hasOne(Hiddens::class, ['id' => 'hidden_id']);
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
