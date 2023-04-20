<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_usersList}}`.
 */
class m230411_080337_create_users_usersList_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_usersList}}', [
            'users_id' => $this->integer()->notNull()->comment('Пользователь'),
            'usersList_id' => $this->integer()->notNull()->comment('Список пользователей'),
        ]);
        $this->addPrimaryKey('pk_users_userList', 'users_usersList', ['users_id', 'usersList_id']);
        $this->addForeignKey(
            'fk_users_usersList_users_id',
            'users_usersList',
            'users_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_usersList_usersList_id',
            'users_usersList',
            'usersList_id',
            'usersList',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_usersList_users_id', 'users_userList');
        $this->dropForeignKey('fk_users_usersList_usersList_id', 'users_userList');
        $this->dropTable('{{%users_userList}}');
    }
}
