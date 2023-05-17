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
