<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roleType}}`.
 */
class m230411_080202_create_roleType_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roleType}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название роли'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%roleType}}');
    }
}
