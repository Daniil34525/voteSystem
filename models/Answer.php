<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


class Answer extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'answer';
    }

    public function rules():array {
        return [
            [['id', 'title', 'question_id'], 'required'], 
            ['voters_id', 'safe']
        ];
    }

    public function attributeLabels():array {
        return [
            'title' => 'Наименование вопроса',
            'voters_id' => 'Класс голосующего : идентификатор голосущего', 
            'question_id' => 'Идентификатор вопроса'
        ];
    }

    public function getQuestion():ActiveQuery {
        return $this->hasOne(Question::class, ['question_id' => 'id']); 
    }
}
