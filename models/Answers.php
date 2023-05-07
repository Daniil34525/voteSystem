<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "answers".
 *
 * @property int $id Идентификатор ответа
 * @property string $title Наименование ответа
 * @property int $question_id Идентификатор вопроса
 * @property array|null $voters голосующие TODO: такой же пункт есть в questions, надо решить что мы оставим
 *
 * @property Questions $question
// * @property Voters[] $votersModels Предполагается два массива(или вообще один), внутри каждого хранятся id
 */
class Answers extends ActiveRecord
{
//    private $votersModels;
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'question_id'], 'required'],
            [['question_id'], 'default', 'value' => null],
            [['question_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['question_id' => 'id']],
            ['voters', 'safe']
//            [['voters'], function () {
//                if (!Model::validateMultiple($this->votersModels)) {
//                    $this->addErrors(ArrayHelper::getColumn($this->votersModels, 'errors'));
//                }
//            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентификатор ответа',
            'title' => 'Наименование ответа',
            'voters' => 'Отвечающие',
            'question_id' => 'Идентификатор вопроса',
        ];
    }

    public function extraFields(): array
    {
        return ['voters']; // Указываем поле JSON в списке дополнительных полей
    }

//    /*********************************************************************************************************
//     *                              EVENTS
//     */
//    public function beforeValidate(): bool
//    {
//        $this->voters = Voters::getDataFromPost();
//        return parent::beforeValidate();
//    }
//
//    public function beforeSave($insert): bool
//    {
//        $this->voters = ArrayHelper::toArray($this->votersModels);
//        return parent::beforeSave($insert);
//    }

//    /** @return Voters[] */
//    public function getVotersModels($createBlank = false): array //Надо тестировать, возможно можно переписать оптимизированнее
//    {
////        if (!is_iterable($this->votersModels) || empty($this->additionalPhones)) {
////            $blankModel = new Voters(['type' => 'Личный', 'number' => '+7'], $this);
////            return $createBlank ? [$blankModel] : [];
////        }
////
////        if (is_null($this->_additionalPhonesModels)) {
////            foreach ($this->additionalPhones as $phone) {
////                $this->_additionalPhonesModels[] = new AdditionalPhone($phone, $this);
////            }
////        }
////
////        return $this->_additionalPhonesModels;
//        if (is_null($this->_votersModels)) {
//            foreach ($this->voters as $voter) {
//                $this->_votersModels[] = new Voters($voter, $this);
//            }
//        }
//
//        return $this->_votersModels;
//    }

    /**
     * Gets query for [[Questions]].
     *
     * @return ActiveQuery
     */
    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Questions::class, ['id' => 'question_id']);
    }
}
