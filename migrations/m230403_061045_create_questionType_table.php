<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionType}}`.
 */
class m230403_061045_create_questionType_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questionType}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull()->comment('Название')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%questionType}}');
    }
}
