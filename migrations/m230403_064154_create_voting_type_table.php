<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%votingType}}`.
 */
class m230403_064154_create_voting_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%voting_type}}',
            [
                'id' => $this->primaryKey()->comment('id'),
                'title' => $this->string()->notNull()->comment('Название')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%voting_type}}');
    }
}
