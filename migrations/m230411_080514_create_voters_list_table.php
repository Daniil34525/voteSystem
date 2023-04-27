<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voterList}}`.
 */
class m230411_080514_create_voters_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voters_list}}', [
            'voter_id' => $this->integer()->notNull()->comment('Голосующий'),
            'voting_id' => $this->integer()->notNull()->comment('Голосование')
        ]);

        $this->addPrimaryKey('pk_voters_list', 'voters_list', ['voter_id', 'voting_id']);

        $this->addForeignKey(
            'fk_voters_list_voter_id',
            'voters_list',
            'voter_id',
            'voters',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_voters_list_voting_id',
            'voters_list',
            'voting_id',
            'votings',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_voters_list_voting_id', '{{%voters_list}}');
        $this->dropForeignKey('fk_voters_list_voter_id', '{{%voters_list}}');
        $this->dropTable('{{%voters_list}}');
    }
}
