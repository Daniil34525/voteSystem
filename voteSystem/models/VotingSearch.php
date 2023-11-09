<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class VotingSearch extends Votings
{
    public function rules(): array
    {
        return [
            [['title', 'voting_type_id'], 'required'],
            [['voters_list_id', 'voting_type_id'], 'default', 'value' => null],
            [['voters_list_id', 'voting_type_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['voters_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => VotersList::class, 'targetAttribute' => ['voters_list_id' => 'id']],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Votings::find()->orderBy('title');

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
