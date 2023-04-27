<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletinList}}`.
 */
class m230411_080921_create_bulletin_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bulletin_list}}', [
            'voting_id' => $this->integer()->notNull()->comment('Голосование'),
            'bulletin_id' => $this->integer()->notNull()->comment('Бюллетень'),
        ]);
        
        $this->addPrimaryKey(
            'pk_bulletin_list_bulletin_id_voting_id', 
            'bulletin_list', 
            ['voting_id', 'bulletin_id']
        );

        $this->addForeignKey(
            'fk_users_bulletin_list_voting_id',
            'bulletin_list',
            'voting_id',
            'voting',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_users_bulletin_list_bulletin_id',
            'bulletin_list',
            'bulletin_id',
            'bulletin',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_bulletin_list_voting_id', 'bulletin_list');
        $this->dropForeignKey('fk_users_bulletin_list_bulletin_id', 'bulletin_list');
        $this->dropTable('{{%bulletin_list}}');
    }
}
