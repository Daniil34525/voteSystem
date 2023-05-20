<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "votings".
 *
 * @property int $id id
 * @property string $title Наименование голосования
 * @property int|null $voters_list_id Идентификатор список избирателей
 * @property int $voting_type_id Идентификатор типа голосования
 * @property int $created_at Дата создания голосования
 *
 * @property VotingTypes $type
 * @property Bulletins[] $bulletins
 * @property BulletinsList[] $bulletinsLists
 * @property VotersList $votersList
 */
class Votings extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'votings';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
                'timeStamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => null,
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'voting_type_id'], 'required'],
            [['voters_list_id', 'voting_type_id', 'created_at'], 'default', 'value' => null],
            [['voters_list_id', 'voting_type_id', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['voters_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => VotersList::class, 'targetAttribute' => ['voters_list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'id',
            'title' => 'Наименование голосования',
            'voters_list_id' => 'Идентификатор список избирателей',
            'voting_type_id' => 'Тип',
            'created_at' => 'Дата создания голосования',
        ];
    }

    /**
     * Gets query for [[VotingType]].
     *
     * @return ActiveQuery
     */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(VotingTypes::class, ['id' => 'voting_type_id']);
    }

    /**
     * Gets query for [[Bulletins]].
     *
     * @return ActiveQuery
     */
    public function getBulletins(): ActiveQuery
    {
        return $this->hasMany(Bulletins::class, ['id' => 'bulletin_id'])->viaTable('bulletins_list', ['voting_id' => 'id']);
    }

    /**
     * Gets query for [[BulletinsLists]].
     *
     * @return ActiveQuery
     */
    public function getBulletinsLists(): ActiveQuery
    {
        return $this->hasMany(BulletinsList::class, ['voting_id' => 'id']);
    }

    /**
     * Gets query for [[VotersList]].
     *
     * @return ActiveQuery
     */
    public function getVotersList(): ActiveQuery
    {
        return $this->hasOne(VotersList::class, ['id' => 'voters_list_id']);
    }
}
