<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @property User $users
 */
class RoleType extends Type
{
    public static function tableName(): string
    {
        return 'roleType';
    }

    public function attributeLabels(): array
    {
        $attributeLabels = ['title' => 'Наименование роли'];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id', 'type_id']);
    }
}
