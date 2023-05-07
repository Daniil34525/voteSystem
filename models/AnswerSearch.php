<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class AnswerSearch extends Answers
{
    public function rules(): array
    {
        return [[['title', 'question_id'], 'required'],
            [['question_id'], 'default', 'value' => null],
            [['question_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['question_id' => 'id']],
            ['voters', 'safe'],
//            [['voters'], function () {
//                if (!Model::validateMultiple($this->votersModels)) {
//                    $this->addErrors(ArrayHelper::getColumn($this->votersModels, 'errors'));
//                }
//            }]
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Answers::find()->orderBy('title');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}