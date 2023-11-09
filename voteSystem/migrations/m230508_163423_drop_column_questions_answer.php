<?php

use yii\db\Migration;

/**
 * Class m230508_163423_delete_column_questions_answer
 */
class m230508_163423_drop_column_questions_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop column from table:
        $this->dropColumn('{{%questions}}', 'answer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Add column into the table:
        $this->addColumn('{{%questions}}', 'answer', $this->json()->comment('Ответы'));
    }
}
