<?php

use yii\db\Migration;

/**
 * Class m230520_154726_drop_not_null_constraint_column_question_id
 */
class m230520_154726_drop_not_null_constraint_column_question_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('answers', 'question_id', $this->integer()->null()->comment('Идентификатор вопроса'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('answers', 'question_id', $this->integer()->notNull()->comment('Идентификатор вопроса'));
    }
}
