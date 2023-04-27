<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bulletins_list".
 *
 * @property int $voting_id Идентификатор голосования
 * @property int $bulletin_id Идентификатор бюллетени
 *
 * @property Bulletins $bulletin
 * @property Votings $voting
 */
class BulletinList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bulletins_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['voting_id', 'bulletin_id'], 'required'],
            [['voting_id', 'bulletin_id'], 'default', 'value' => null],
            [['voting_id', 'bulletin_id'], 'integer'],
            [['voting_id', 'bulletin_id'], 'unique', 'targetAttribute' => ['voting_id', 'bulletin_id']],
            [['bulletin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bulletins::class, 'targetAttribute' => ['bulletin_id' => 'id']],
            [['voting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Votings::class, 'targetAttribute' => ['voting_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'voting_id' => 'Идентификатор голосования',
            'bulletin_id' => 'Идентификатор бюллетени',
        ];
    }

    /**
     * Gets query for [[Bulletin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBulletin()
    {
        return $this->hasOne(Bulletins::class, ['id' => 'bulletin_id']);
    }

    /**
     * Gets query for [[Voting]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVoting()
    {
        return $this->hasOne(Votings::class, ['id' => 'voting_id']);
    }
}
