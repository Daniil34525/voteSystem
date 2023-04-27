<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voting_types".
 *
 * @property int $id id
 * @property string $title Название
 */
class VottingType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voting_types';
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
            'id' => 'id',
            'title' => 'Название',
        ];
    }
}
