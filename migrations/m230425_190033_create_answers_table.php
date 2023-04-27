<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m230425_190033_create_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answers}}', [
            'id' => $this->primaryKey()->comment('Идентификатор вопроса'), 
            'title' => $this->string()->notNull()->comment('Наименование вопроса'),
            'voters' => $this->json()->comment("Предполагается две колонки: Class::voter, id избирателя"), 
            'question_id' => $this->integer()->notNull()->comment('Идентификатор вопроса')
        ]);

        $this->addForeignKey(
            'fk_answer_question_id', 
            'answers', 
            'question_id', 
            'questions', 
            'id', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answers}}');
    }
}
