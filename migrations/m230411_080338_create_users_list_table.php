<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usersList}}`.
 */
class m230411_080338_create_users_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_list}}', [
            'voter_list_id' => $this->integer()->comment('Идентификатор списка избирателей'),
            'user_id' => $this->integer()->comment('Идентификатор пользователя')
        ]);

        $this->addPrimaryKey('pk_users_list', 'users_list', ['voter_list_id', 'user_id']);

        $this->addForeignKey(
            'fk_users_list_voters_list_id',
            'users_list',
            'voter_list_id',
            'voters_list',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_users_list_users_id',
            'users_list',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_list_voters_list_id', '{{%users_list}}');
        $this->dropForeignKey('fk_users_list_users_id','{{%users_list}}');
        $this->dropPrimaryKey('pk_users_list', '{{%users_list}}');
        $this->dropTable('{{%users_list}}');
    }
}
