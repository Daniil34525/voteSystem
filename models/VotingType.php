<?php

namespace app\models;

class VotingType extends Type
{
    public static function tableName(): string
    {
        return 'votingType';
    }

    public function attributeLabels(): array
    {
        $attributeLabels = ['title' => 'Наименование типа голосования'];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
}