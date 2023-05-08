<?php

use yii\db\Migration;

/**
 * Class m230506_153302_add_column_voters_list_title
 */
class m230506_153302_add_column_voters_list_title extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%voters_list}}', 'title', $this->string(100)->comment("Заголовок списка"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%voters_list}}', 'title');
    }
}
