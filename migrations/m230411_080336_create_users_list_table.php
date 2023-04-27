<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usersList}}`.
 */
class m230411_080336_create_users_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_list}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Наименование списка пользователей'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания списка'),
            'updated_at' => $this->integer()->comment('Дата изменения списка'),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_list}}');
    }
}
