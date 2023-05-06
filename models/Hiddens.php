<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hiddens".
 *
 * @property int $id Идентифактор анонимного участника
 * @property string $code Код-пароль
 *
 * @property HiddensList[] $hiddensLists
 * @property VotersList[] $voterLists
 */
class Hiddens extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'hiddens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'Идентифактор анонимного участника',
            'code' => 'Код-пароль',
        ];
    }

    public static function get_random_code($length=8): string
    {
        $regex = '/[^a-zA-Z0-9]/';
        $randomString = '';
        while (strlen($randomString) < $length) {
            $randomString .= preg_replace($regex, '', chr(random_int(1, 255)));
        }
        return $randomString;
    }

    /**
     * Gets query for [[HiddensLists]].
     *
     * @return ActiveQuery
     */
    public function getHiddensLists(): ActiveQuery
    {
        return $this->hasMany(HiddensList::class, ['hidden_id' => 'id']);
    }

    /**
     * Gets query for [[VoterLists]].
     *
     * @return ActiveQuery
     */
    public function getVoterLists(): ActiveQuery
    {
        return $this->hasMany(VotersList::class, ['id' => 'voter_list_id'])->viaTable('hiddens_list', ['hidden_id' => 'id']);
    }
}
