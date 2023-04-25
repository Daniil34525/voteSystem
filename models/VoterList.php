<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class VoterList extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'voterList';
    }

    public function rules(): array
    {
        return [
            [['voterId', 'votingId'], ['requried', 'integer']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'voterId' => 'Идентификатор участника',
            'votingId' => 'Идентификатор голосования',
        ];
    }
}
