<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hiddens_list".
 *
 * @property int $voter_list_id Идентификатор списка избирателей
 * @property int $hidden_id Голосование
 *
 * @property Hiddens $hidden
 * @property VotersList $voterList
 */
class HiddenList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hiddens_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function attributeLabels()
    {
        return [
            'voter_list_id' => 'Идентификатор списка избирателей',
            'hidden_id' => 'Голосование',
        ];
    }

    /**
     * Gets query for [[Hidden]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHidden()
    {
        return $this->hasOne(Hiddens::class, ['id' => 'hidden_id']);
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
