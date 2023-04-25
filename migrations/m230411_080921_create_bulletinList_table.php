<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletinList}}`.
 */
class m230411_080921_create_bulletinList_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bulletinList}}', [
            'voting_id' => $this->integer()->notNull()->comment('Голосование'),
            'bulletin_id' => $this->integer()->notNull()->comment('Бюллетень'),
        ]);
        
        $this->addPrimaryKey(
            'PK_bulletinList_bulletin_id_voting_id', 
            'bulletinList', 
            ['voting_id', 'bulletin_id']
        );

        $this->addForeignKey(
            'fk_users_bulletinList_voting_id',
            'bulletinList',
            'voting_id',
            'voting',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_users_bulletinList_bulletin_id',
            'bulletinList',
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
        $this->dropForeignKey('fk_users_bulletinList_voting_id', 'bulletinList');
        $this->dropForeignKey('fk_users_bulletinList_bulletin_id', 'bulletinList');
        $this->dropTable('{{%bulletinList}}');
    }
}
