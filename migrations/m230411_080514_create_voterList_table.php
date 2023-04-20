<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voterList}}`.
 */
class m230411_080514_create_voterList_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voterList}}', [
            'voterId' => $this->integer()->notNull()->comment('Голосующий'),
            'votingId' => $this->integer()->notNull()->comment('Голосование')
        ]);
        $this->addForeignKey(
            'fk_voterList_voterId',
            'voterList',
            'voterId',
            'voter',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_voterList_votingId',
            'voterList',
            'votingId',
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
        $this->dropForeignKey('fk_voterList_votingId', 'voterList');
        $this->dropForeignKey('fk_voterList_voterId', 'voterList');
        $this->dropTable('{{%voterList}}');
    }
}
