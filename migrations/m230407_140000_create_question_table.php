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
                'title' => $this->string()->notNull()->comment('Название'),
                'bulletinId' => $this->integer()->notNull()->comment('Бюллетень'),
                'overview' => $this->text()->comment('Описание вопроса'),
                'typeId' => $this->integer()->notNull()->comment('Тип вопроса'),
                'answer' => $this->json()->comment('Ответ')
            ]
        );
        $this->addForeignKey(
            'fk_question_typeId',
            'question',
            'typeId',
            'questionType',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_question_bulletinId',
            'question',
            'bulletinId',
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
        $this->dropForeignKey('fk_question_bulletinId', '{{%question}}');
        $this->dropForeignKey('fk_question_typeId', '{{%question}}');
        $this->dropTable('{{%question}}');
    }
}
