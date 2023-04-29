<?php

namespace app\models;

use yii\db\ActiveRecord;

abstract class Type extends ActiveRecord
{
    abstract public static function getTableName();

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентификтор',
            'title' => 'Наименование',
        ];
    }
}