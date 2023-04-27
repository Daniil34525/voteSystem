<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletinList}}`.
 */
class m230411_080921_create_bulletins_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bulletins_list}}', [
            'voting_id' => $this->integer()->notNull()->comment('Голосование'),
            'bulletin_id' => $this->integer()->notNull()->comment('Бюллетень'),
        ]);
        
        $this->addPrimaryKey(
            'pk_bulletins_list_bulletin_id_voting_id', 
            'bulletins_list', 
            ['voting_id', 'bulletin_id']
        );

        $this->addForeignKey(
            'fk_users_bulletins_list_voting_id',
            'bulletins_list',
            'voting_id',
            'votings',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_users_bulletins_list_bulletin_id',
            'bulletins_list',
            'bulletin_id',
            'bulletins',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_bulletins_list_voting_id', '{{%bulletins_list}}');
        $this->dropForeignKey('fk_users_bulletins_list_bulletin_id', '{{%bulletins_list}}');
        $this->dropTable('{{%bulletins_list}}');
    }
}
