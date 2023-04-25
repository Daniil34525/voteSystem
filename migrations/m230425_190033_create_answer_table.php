<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m230425_190033_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Наименование вопроса'),
            'voters_id' => $this->json()->comment("Предполагается две колонки: Class::voter, id_voter"), 
            'question_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_answer_question_id', 
            'answer', 
            'question_id', 
            'question', 
            'id', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%answer}}');
    }
}
