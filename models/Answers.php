<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "answers".
 *
 * @property int $id Идентификатор вопроса
 * @property string $title Наименование вопроса
 * @property string|null $voters Предполагается две колонки: Class::voter, id избирателя
 * @property int $question_id Идентификатор вопроса
 *
 * @property Questions $question
 */
class Answers extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'question_id'], 'required'],
            [['voters'], 'safe'],
            [['question_id'], 'default', 'value' => null],
            [['question_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентификатор вопроса',
            'title' => 'Наименование вопроса',
            'voters' => 'Предполагается две колонки: Class::voter, id избирателя',
            'question_id' => 'Идентификатор вопроса',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return ActiveQuery
     */
    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Questions::class, ['id' => 'question_id']);
    }
}
