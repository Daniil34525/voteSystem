<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voterList}}`.
 */
class m230411_080514_create_voter_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voter_list}}', [
            'voter_id' => $this->integer()->notNull()->comment('Голосующий'),
            'voting_id' => $this->integer()->notNull()->comment('Голосование')
        ]);

        $this->addPrimaryKey('pk_voter_list', 'voter_list', ['voter_id', 'voting_id']);

        $this->addForeignKey(
            'fk_voter_list_voter_id',
            'voter_list',
            'voter_id',
            'voter',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_voter_list_voting_id',
            'voter_list',
            'voting_id',
            'voting',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_voter_list_voting_id', 'voter_list');
        $this->dropForeignKey('fk_voter_list_voter_id', 'voter_list');
        $this->dropTable('{{%voter_list}}');
    }
}
