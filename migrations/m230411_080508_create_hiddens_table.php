<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voter}}`.
 */
class m230411_080508_create_hiddens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hiddens}}', [
            'id' => $this->primaryKey()->comment('Идентифактор анонимного участника'),
            'code' => $this->string()->notNull()->comment('Код-пароль'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%hiddens}}');
    }
}
