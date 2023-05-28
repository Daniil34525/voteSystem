<?php

use yii\db\Migration;

/**
 * Class m230528_114123_add_column_is_selected_bulletins
 */
class m230528_114123_add_column_is_selected_bulletins extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bulletins}}', 'is_selected', $this->boolean()->defaultValue(false)->comment("Выбран ли"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bulletins}}', 'is_selected');
    }
}
