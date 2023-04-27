<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $id Идентификатор вопроса
 * @property string $question_title Сам вопрос
 * @property int|null $bulletin_id Идентификатор бюллетени
 * @property string|null $overview Дополнительное описание сути вопроса
 * @property int $type_id Идентификтор типа вопроса
 * @property string|null $answer Ответы
 *
 * @property Answers[] $answers
 * @property Bulletins $bulletin
 * @property QuestionTypes $type
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_title', 'type_id'], 'required'],
            [['bulletin_id', 'type_id'], 'default', 'value' => null],
            [['bulletin_id', 'type_id'], 'integer'],
            [['overview'], 'string'],
            [['answer'], 'safe'],
            [['question_title'], 'string', 'max' => 255],
            [['bulletin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bulletins::class, 'targetAttribute' => ['bulletin_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionTypes::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор вопроса',
            'question_title' => 'Сам вопрос',
            'bulletin_id' => 'Идентификатор бюллетени',
            'overview' => 'Дополнительное описание сути вопроса',
            'type_id' => 'Идентификтор типа вопроса',
            'answer' => 'Ответы',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::class, ['question_id' => 'id']);
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
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(QuestionTypes::class, ['id' => 'type_id']);
    }
}
