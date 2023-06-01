<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "bulletins".
 *
 * @property int $id Код бюллетени
 * @property string $title Название
 * @property bool $is_selected Выбран ли
 * @property int $created_at Дата создания
 *
 * @property BulletinsList[] $bulletinsLists
 * @property Questions[] $questions
 * @property Votings[] $votings
 * 
 */
class Bulletins extends ActiveRecord
{
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at', 
                'updatedAtAttribute' => false
            ],
            
        ]; 
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'bulletins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['id', 'integer'], 
            ['title', 'required'],
            ['title', 'string', 'max' => 255],
            ['is_selected', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Код бюллетени',
            'title' => 'Наименование',
            'created_at' => 'Дата создания',
        ];
    }

    public static function get_list_items()
    {
        # Gets all records from Bulletins with 'id' and 'title' as array:
        $model_items = Bulletins::find()->select(['id', 'title'])->asArray()->all();

        # Creates the data associative array with key -> id and value -> title:
        $data = [];

        # Adds data to this data array with data from Bulletins model:
        foreach ($model_items as $model) {
            $data[$model["id"]] = $model['title'];
        }

        return $data;
    }

    /**
     * Gets query for [[BulletinsLists]].
     *
     * @return ActiveQuery
     */
    public function getBulletinsLists(): ActiveQuery
    {
        return $this->hasMany(BulletinsList::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return ActiveQuery
     */
    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Questions::class, ['bulletin_id' => 'id']);
    }

    /**
     * Gets query for [[Votings]].
     *
     * @return ActiveQuery
     */
    public function getVotings(): ActiveQuery
    {
        return $this->hasMany(Votings::class, ['id' => 'voting_id'])->viaTable('bulletins_list', ['bulletin_id' => 'id']);
    }
}
