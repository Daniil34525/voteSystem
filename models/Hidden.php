<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hiddens".
 *
 * @property int $id Идентифактор анонимного участника
 * @property string $code Код-пароль
 *
 * @property HiddensList[] $hiddensLists
 * @property VotersList[] $voterLists
 */
class Hidden extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hiddens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентифактор анонимного участника',
            'code' => 'Код-пароль',
        ];
    }

    /**
     * Gets query for [[HiddensLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHiddensLists()
    {
        return $this->hasMany(HiddensList::class, ['hidden_id' => 'id']);
    }

    /**
     * Gets query for [[VoterLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoterLists()
    {
        return $this->hasMany(VotersList::class, ['id' => 'voter_list_id'])->viaTable('hiddens_list', ['hidden_id' => 'id']);
    }
}
