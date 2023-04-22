<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 */
class Type extends ActiveRecord
{
    public function rules(): array
    {
        return
            [
                ['title', ['required', 'string']],
                ['id', 'integer']
            ];
    }

    public function attributeLabels(): array
    {
        return ['id' => 'Id'];
    }
}
