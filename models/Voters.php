<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * TODO: Не используется, оставил на всякий случай
 */
class Voters extends Model
{
    public static $extendedFormName = 'Answers[voters]';
    public $classVoter;
    public $idVoter;

    /** @inheritdoc */
    public function formName(): string
    {
        return self::$extendedFormName;
    }

    /** @var string[] Для AppLogBehavior */
    const ATTRIBUTE_LABELS = [
        'classVoter' => 'Класс голосующего',
        'idVoter' => 'id голосующего',
    ];

    public function getOwner(): ?ActiveRecord
    {
        return $this->owner;
    }

    /** @param array $config Содержимое json-полей */
    public function __construct($config = [], ActiveRecord $owner = null)
    {
        //$this->owner = $owner;

        if (is_iterable($config)) {
            foreach ($config as $attribute => $value) {
                if (!in_array($attribute, $this->attributes())) {
                    unset($config[$attribute]);
                }
            }
        }
        parent::__construct($config);
    }

//    /** @param array $config Содержимое json-полей address, passport итд в таблицах bids и objects */
//    public function __construct($config = [], ActiveRecord $owner = null)
//    {
//        $this->owner = $owner;
//
//        if (is_iterable($config)) {
//            foreach ($config as $attribute => $value) {
//                if (!in_array($attribute, $this->attributes())) {
//                    unset($config[$attribute]);
//                }
//            }
//        }
//        parent::__construct($config);
//    }

    public static function getRequiredAttributes(): array
    {
        return ['classVoter', 'idVoter'];
    }

    public function rules(): array
    {
        return [
            ['classVoter', 'string', 'max' => 50],
            ['idVoter', 'integer']
        ];
    }

    /*****************************************************************************************************
     *                              STATIC  FUNCTIONS
     *
     * Из массива $_POST удаляем невалидные элементы, из оставшихся создаем модели
     */
    public static function getDataFromPost(): ?array
    {
        if (empty($_POST['Answers']['Voters'])) {
            return null;
        }

        $data = $_POST['Answers']['Voters'];
        return array_filter($data, function($item) {
            return !empty($item['classVoter']) && !empty($item['idVoter']);
        });
    }
}
