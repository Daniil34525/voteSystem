<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bulletins".
 *
 * @property int $id Код бюллетени
 * @property string $title Название
 * @property int $created_at Дата создания
 *
 * @property BulletinsList[] $bulletinsLists
 * @property Questions[] $questions
 * @property Votings[] $votings
 */
class Bulletin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bulletins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'created_at'], 'required'],
            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код бюллетени',
            'title' => 'Название',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[BulletinsLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBulletinsLists()
    {
        return $this->hasMany(BulletinsList::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotings()
    {
        return $this->hasMany(Votings::class, ['id' => 'voting_id'])->viaTable('bulletins_list', ['bulletin_id' => 'id']);
    }
}
