<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ballotList}}`.
 */
class m230411_080921_create_ballotList_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ballotList}}', [
            'voting_id' => $this->integer()->notNull()->comment('Голосование'),
            'bulletin_id' => $this->integer()->notNull()->comment('Бюллетень'),
        ]);
        $this->addForeignKey(
            'fk_users_ballotList_voting_id',
            'ballotList',
            'voting_id',
            'voting',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_users_ballotList_bulletin_id',
            'ballotList',
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
        $this->dropForeignKey('fk_users_ballotList_voting_id', 'ballotList');
        $this->dropForeignKey('fk_users_ballotList_bulletin_id', 'ballotList');
        $this->dropTable('{{%ballotList}}');
    }
}
