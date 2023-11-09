<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "questions".
 *
 * @property int $id Идентификатор вопроса
 * @property string $question_title Сам вопрос
 * @property int|null $bulletin_id Идентификатор бюллетени
 * @property string|null $overview Дополнительное описание сути вопроса
 * @property int $type_id Идентификтор типа вопроса
 *
 * @property Answers[] $answers
 * @property Bulletins $bulletin
 * @property QuestionTypes $type
 */
class Questions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['question_title', 'type_id'], 'required'],
            [['bulletin_id', 'type_id'], 'default', 'value' => null],
            [['bulletin_id', 'type_id'], 'integer'],
            [['overview'], 'string'],
            [['question_title'], 'string', 'max' => 255],
            [['bulletin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bulletins::class, 'targetAttribute' => ['bulletin_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionTypes::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентификатор вопроса',
            'question_title' => 'Сам вопрос',
            'bulletin_id' => 'Бюллетень',
            'overview' => 'Дополнительное описание вопроса',
            'type_id' => 'Тип вопроса',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return ActiveQuery
     */
    public function getAnswers(): ActiveQuery
    {
        return $this->hasMany(Answers::class, ['question_id' => 'id']);
    }

    /**
     * Gets query for [[Bulletins]].
     *
     * @return ActiveQuery
     */
    public function getBulletin(): ActiveQuery
    {
        return $this->hasOne(Bulletins::class, ['id' => 'bulletin_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return ActiveQuery
     */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(QuestionTypes::class, ['id' => 'type_id']);
    }
}
