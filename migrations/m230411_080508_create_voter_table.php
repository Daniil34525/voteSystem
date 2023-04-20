<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voter}}`.
 */
class m230411_080508_create_voter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voter}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%voter}}');
    }
}
