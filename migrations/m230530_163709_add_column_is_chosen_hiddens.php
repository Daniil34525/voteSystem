<?php

use yii\db\Migration;

/**
 * Class m230530_163709_add_column_is_chosen_hiddens
 */
class m230530_163709_add_column_is_chosen_hiddens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hiddens', 'is_chosen', $this->boolean()->defaultValue(false)->comment('был ли выбран пользователь'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hiddens', 'is_chosen');
    }
}
