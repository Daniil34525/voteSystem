<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Bulletin extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'bulletin';
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
        return [
            ['created_at', 'required'],
            ['title', 'string'],
            [['id', 'created_at'], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'created_at' => 'Дата создания',
        ];
    }

    public function getQuestions():ActiveQuery {
        return $this->hasMany(Question::class, ['id' => 'bulletinId']); 
    }
}