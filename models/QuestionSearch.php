<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Questions;

/**
 * QuestionSearch represents the model behind the search form of `app\models\Questions`.
 */
class QuestionSearch extends Questions
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['question_title', 'type_id'], 'required'],
            [['bulletin_id', 'type_id'], 'default', 'value' => null],
            [['bulletin_id', 'type_id'], 'integer'],
            [['overview'], 'string'],
            [['question_title'], 'string', 'max' => 255],
            [['bulletin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bulletins::class, 'targetAttribute' => ['bulletin_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionTypes::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Questions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bulletin_id' => $this->bulletin_id,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['ilike', 'question_title', $this->question_title])
            ->andFilterWhere(['ilike', 'overview', $this->overview]);

        return $dataProvider;
    }
}
