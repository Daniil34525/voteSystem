<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voting}}`.
 */
class m230411_080510_create_votings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%votings}}',
            [
                'id' => $this->primaryKey()->comment('id'),
                'title' => $this->string()->notNull()->comment('Наименование голосования'),
                'voters_list_id' => $this->integer()->comment('Идентификатор список избирателей'),
                'voting_type_id' => $this->integer()->notNull()->comment('Идентификатор типа голосования'), 
                'created_at' => $this->integer()->notNull()->comment('Дата создания голосования')
            ]
        );

        // FR with voters_list table if voting_type_id is suitable:
        $this->addForeignKey(
            'fk_votings_voters_list_id',
            'votings',
            'voters_list_id',
            'voters_list',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_votings_voters_list_id', '{{%votings}}');
        $this->dropTable('{{%votings}}');
    }
}
