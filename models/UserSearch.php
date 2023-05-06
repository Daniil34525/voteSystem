<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UserSearch represents the model behind the search form of `app\models\Users`.
 */
class UserSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'phone', 'password_hash', 'role_type_id'], 'required'],
            [['role_type_id'], 'default', 'value' => null],
            [['role_type_id'], 'integer'],
            [['name', 'middle_name', 'last_name', 'email', 'phone', 'password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['role_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleTypes::class, 'targetAttribute' => ['role_type_id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Users::find();

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
            'role_type_id' => $this->role_type_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'middle_name', $this->middle_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'password_hash', $this->password_hash]);

        return $dataProvider;
    }
}
