<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m230407_140000_create_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questions}}',
            [
                'id' => $this->primaryKey()->comment('Идентификатор вопроса'),
                'question_title' => $this->string()->notNull()->comment('Сам вопрос'),
                'bulletin_id' => $this->integer()->comment('Идентификатор бюллетени'),
                'overview' => $this->text()->comment('Дополнительное описание сути вопроса'),
                'type_id' => $this->integer()->notNull()->comment('Идентификтор типа вопроса'),
                'answer' => $this->json()->comment('Ответы')
            ]
        );
        $this->addForeignKey(
            'fk_question_types_id',
            'questions',
            'type_id',
            'question_types',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_questions_bulletin_id',
            'questions',
            'bulletin_id',
            'bulletins',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_questions_bulletin_id', '{{%questions}}');
        $this->dropForeignKey('fk_question_types_id', '{{%questions}}');
        $this->dropTable('{{%questions}}');
    }
}
