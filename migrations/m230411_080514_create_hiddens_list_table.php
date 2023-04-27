<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%voterList}}`.
 */
class m230411_080514_create_hiddens_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hiddens_list}}', [
            'voter_list_id' => $this->integer()->notNull()->comment('Идентификатор списка избирателей'),
            'hidden_id' => $this->integer()->notNull()->comment('Голосование')
        ]);

        $this->addPrimaryKey('pk_hiddens_list', 'hiddens_list', ['voter_list_id', 'hidden_id']);

        $this->addForeignKey(
            'fk_hiddens_list_voters_list_id',
            'hiddens_list',
            'voter_list_id',
            'voters_list',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_hiddens_list_hiddens_id',
            'hiddens_list',
            'hidden_id',
            'hiddens',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_hiddens_list_hiddens_id', '{{%hiddens_list}}');
        $this->dropForeignKey('fk_hiddens_list_voters_list_id', '{{%hiddens_list}}');
        $this->dropPrimaryKey('pk_hiddens_list','{{%hiddens_list}}');
        $this->dropTable('{{%hiddens_list}}');
    }
}
