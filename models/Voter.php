<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $code
 * @property integer $created_at
 */

class Voter extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'voter';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
            ],
        ];
    }

    public function rules(): array
    {
        return
            [
                ['code', 'created_at', 'required'],
                ['code', 'string'],
                [['id', 'created_at'], 'integer'],
            ];
    }

    public function attributeLabels(): array
    {
        return
            [
                'code' => 'Код-пароль',
                'created_at' => 'Дата создания',
            ];
    }

    //планируется, что метод должен возвращать произвольную строку для создания код-пароля
    public function getRandomString(): string
    {
        return 'a';
    }
}