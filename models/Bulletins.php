<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Bulletins extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'bulletins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getBulletinsLists(): ActiveQuery
    {
        return $this->hasMany(BulletinsList::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return ActiveQuery
     */
    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Questions::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return ActiveQuery
     */
    public function getVotings(): ActiveQuery
    {
        return $this->hasMany(Votings::class, ['id' => 'voting_id'])->viaTable('bulletins_list', ['bulletin_id' => 'id']);
    }
}
