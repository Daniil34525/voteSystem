<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TypeSearch extends Model
{
    public $modelClass;

    public $id;
    public $title;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['title'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = $this->modelClass::find()->orderBy('title');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'title' => [
                        'asc' => ['title' => SORT_ASC],
                        'desc' => ['title' => SORT_DESC]
                    ],
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC]
                    ]
                ]
            ]
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
