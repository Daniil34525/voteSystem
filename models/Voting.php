<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votings".
 *
 * @property int $id id
 * @property string $title Наименование голосования
 * @property int|null $voters_list_id Идентификатор список избирателей
 * @property int $voting_type_id Идентификатор типа голосования
 * @property int $created_at Дата создания голосования
 *
 * @property Bulletins[] $bulletins
 * @property BulletinsList[] $bulletinsLists
 * @property VotersList $votersList
 */
class Voting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'voting_type_id', 'created_at'], 'required'],
            [['voters_list_id', 'voting_type_id', 'created_at'], 'default', 'value' => null],
            [['voters_list_id', 'voting_type_id', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['voters_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => VotersList::class, 'targetAttribute' => ['voters_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'title' => 'Наименование голосования',
            'voters_list_id' => 'Идентификатор список избирателей',
            'voting_type_id' => 'Идентификатор типа голосования',
            'created_at' => 'Дата создания голосования',
        ];
    }

    /**
     * Gets query for [[Bulletins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBulletins()
    {
        return $this->hasMany(Bulletins::class, ['id' => 'bulletin_id'])->viaTable('bulletins_list', ['voting_id' => 'id']);
    }

    /**
     * Gets query for [[BulletinsLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBulletinsLists()
    {
        return $this->hasMany(BulletinsList::class, ['voting_id' => 'id']);
    }

    /**
     * Gets query for [[VotersList]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVotersList()
    {
        return $this->hasOne(VotersList::class, ['id' => 'voters_list_id']);
    }
}
