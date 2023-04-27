<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voter}}`.
 */
class m230411_080508_create_voters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voters}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull()->comment('Код-пароль'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%voters}}');
    }
}
