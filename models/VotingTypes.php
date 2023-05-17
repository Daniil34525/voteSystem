<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "voting_types".
 *
 * @property int $id id
 * @property string $title Название
 *
 * @property Votings[] $votings
 */
class VotingTypes extends Type
{
    public static function getTableName(): string
    {
        return 'voting_types';
    }

    public static function get_list_items(): array
    {
        $model_items = VotingTypes::find()->select(['id', 'title'])->asArray()->all();

        $data = [];

        foreach ($model_items as $model) {
            $data[$model["id"]] = $model['title'];
        }

        return $data;
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return ActiveQuery
     */
    public function getVotings(): ActiveQuery
    {
        return $this->hasMany(Votings::class, ['voting_type_id' => 'id']);
    }
}
