<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_usersList}}`.
 */
class m230411_080337_create_users_users_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_users_list}}', [
            'users_id' => $this->integer()->notNull()->comment('Пользователь'),
            'users_list_id' => $this->integer()->notNull()->comment('Список пользователей'),
        ]);
        $this->addPrimaryKey('pk_users_user_list', 'users_users_list', ['users_id', 'users_list_id']);
        $this->addForeignKey(
            'fk_users_users_list_users_id',
            'users_users_list',
            'users_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_users_list_users_list_id',
            'users_users_list',
            'users_list_id',
            'users_list',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_users_list_users_id', '{{%users_users_list}}');
        $this->dropForeignKey('fk_users_list_users_list_id', '{{%users_users_list}}');
        $this->dropTable('{{%users_users_list}}');
    }
}
