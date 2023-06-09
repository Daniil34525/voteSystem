<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletin}}`.
 */
class m230407_132955_create_bulletins_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bulletins}}',
            [
                'id' => $this->primaryKey()->comment('Код бюллетени'),
                'title' => $this->string()->notNull()->comment('Название'),
                'created_at' => $this->integer()->notNull()->comment('Дата создания')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bulletins}}');
    }
}
