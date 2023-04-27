<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m230407_140000_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}',
            [
                'id' => $this->primaryKey()->comment('Код вопроса'),
                'question_title' => $this->string()->notNull()->comment('Наименование вопроса'),
                'bulletin_id' => $this->integer()->comment('Бюллетень'),
                'overview' => $this->text()->comment('Описание вопроса'),
                'type_id' => $this->integer()->notNull()->comment('Тип вопроса'),
                'answer' => $this->json()->comment('Ответ')
            ]
        );
        $this->addForeignKey(
            'fk_question_type_id',
            'question',
            'type_id',
            'question_type',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_question_bulletin_id',
            'question',
            'bulletin_id',
            'bulletin',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_question_bulletin_id', '{{%question}}');
        $this->dropForeignKey('fk_question_type_id', '{{%question}}');
        $this->dropTable('{{%question}}');
    }
}
