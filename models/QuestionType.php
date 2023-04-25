<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @property Question $questions
 */

class QuestionType extends Type
{
    public static function tableName(): string
    {
        return 'questionType';
    }

    public function attributeLabels(): array
    {
        $attributeLabels = ['title' => 'Наименование типа вопроса'];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }

    public function getQuestion(): ActiveQuery
    {
        return $this->hasMany(Question::class, ['id', 'typeId']);
    }
}