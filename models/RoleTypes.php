<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_types".
 *
 * @property int $id Идентификтор роли
 * @property string $title Наименование роли
 *
 * @property Users[] $users
 */
class RoleTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификтор роли',
            'title' => 'Наименование роли',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['role_type_id' => 'id']);
    }
}
