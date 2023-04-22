<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 * @property string $overview
 * @property string $answer
 * @property integer $created_at
 *
 * @property Bulletin $bulletin
 * @property QuestionType $type
 */
class Question extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'question';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
            ],
        ];
    }

    public function rules(): array
    {
        return
            [
                [['title', 'created_at', 'bulletinId', 'typeId'], 'required'],
                [['title', 'overview'], 'string'],
                [['id', 'created_at', 'bulletinId', 'typeId'], 'integer'],
                ['answer', 'jsonb'],
            ];
    }

    public function attributeLabels(): array
    {
        return
            [
                'title' => 'Наименование вопроса',
                'overview' => 'Описание',
                'created_at' => 'Дата создания',
                'bulletinId' => 'Бюллетень',
                'typeId' => 'Тип бюллетени',
            ];
    }

    public function getQuestionType(): ActiveQuery
    {
        return $this->hasOne(QuestionType::class, ['typeId' => 'id']);
    }

    public function getBulletin(): ActiveQuery
    {
        return $this->hasOne(Bulletin::class, ['bulletinId' => 'id']);
    }
}
