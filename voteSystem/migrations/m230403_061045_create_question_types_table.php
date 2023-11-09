<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questionType}}`.
 */
class m230403_061045_create_question_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question_types}}',
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
        $this->dropTable('{{%question_types}}');
    }
}
