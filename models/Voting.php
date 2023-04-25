<?php 

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Voting extends ActiveRecord {

    public static function tableName():string {
        return 'voting'; 
    }

    public function rules(): array
    {
        return [
            [['id', 'title', 'created_at'], 'requried'],
            [['id', 'user_listId', 'created_at'], 'integer']
        ];
    }
}