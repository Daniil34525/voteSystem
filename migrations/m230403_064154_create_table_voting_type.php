<?php

use yii\db\Migration;

/**
 * Class m230403_064154_create_table_voting_type
 */
class m230403_064154_create_table_voting_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230403_064154_create_table_voting_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230403_064154_create_table_voting_type cannot be reverted.\n";

        return false;
    }
    */
}
