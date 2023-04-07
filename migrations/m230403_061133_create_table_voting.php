<?php

use yii\db\Migration;

/**
 * Class m230403_061133_create_table_voting
 */
class m230403_061133_create_table_voting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('voting',
        [

        ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230403_061133_create_table_voting cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230403_061133_create_table_voting cannot be reverted.\n";

        return false;
    }
    */
}
