<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voting}}`.
 */
class m230411_080510_create_voting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voting}}',
            [
                'id' => $this->primaryKey()->comment('id'),
                'title' => $this->string()->notNull()->comment('Название'),
                'users_listId' => $this->integer()->comment('Список пользователей голосования'),
                'created_at' => $this->integer()->notNull()->comment('Дата создания голосования')
            ]
        );
        $this->addForeignKey(
            'fk_voting_users_listId',
            'voting',
            'users_listId',
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
        $this->dropForeignKey('fk_voting_users_listId', 'voting');
        $this->dropTable('{{%voting}}');
    }
}
