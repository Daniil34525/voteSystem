<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "question_types".
 *
 * @property int $id
 * @property string $title Название
 *
 * @property Questions[] $questions
 */
class QuestionTypes extends Type
{
    public static function getTableName(): string
    {
        return 'question_types';
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return ActiveQuery
     */
    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Questions::class, ['type_id' => 'id']);
    }
}
