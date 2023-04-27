<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_usersList}}`.
 */
class m230411_080337_create_voters_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voters_list}}', [
            'id' => $this->primaryKey()->comment('Идентификатор списка избирателей'),
            'created_at' => $this->integer()->notNull()->comment('Время создания списка'),
            'updated_at' => $this->integer()->comment('Время обновления списка'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%voters_list}}');
    }
}
