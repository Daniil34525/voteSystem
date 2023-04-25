<?php


namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UserList extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'userList';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['id', 'title', 'created_at'], 'requried'],
            [['id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    public function attributeLabels():array {
        return [
            'title' => 'Название списка голосующих', 
            'created_at' => 'Время создания', 
            'updated_at' => 'Время последнего обновления'
        ];
    }
    // public function getUser():ActiveQuery {
    //     return $this->hasMany(User::class, ['question_id' => 'id']); 
    // }
}
