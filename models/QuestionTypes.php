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

    public static function get_list_items()
    {
        # Gets all records from Bulletins with 'id' and 'title' as array:
        $model_items = QuestionTypes::find()->select(['id', 'title'])->asArray()->all();

        # Creates the data associative array with key -> id and value -> title:
        $data = [];

        # Adds data to this data array with data from Bulletins model:
        foreach ($model_items as $model) {
            $data[$model["id"]] = $model['title'];
        }

        return $data;
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
