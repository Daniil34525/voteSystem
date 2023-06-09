<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "role_types".
 *
 * @property int $id Идентификтор роли
 * @property string $title Наименование роли
 *
 * @property Users[] $users
 */
class RoleTypes extends Type
{
    public static function getTableName(): string
    {
        return 'role_types';
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function attributeLabels(): array
//    {
//        return [
//            'id' => 'Идентификтор роли',
//            'title' => 'Наименование роли',
//        ];
//    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::class, ['role_type_id' => 'id']);
    }

    public static function get_list_items() {
        $model_types = RoleTypes::find()->select(['id', 'title'])->asArray()->all();

        $data = []; 
        
        foreach ($model_types as $model) {
            $data[$model["id"]] = $model['title'];
        }
          
        return $data;
    }
}
