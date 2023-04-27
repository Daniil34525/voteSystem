<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roleType}}`.
 */
class m230411_080202_create_role_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название роли'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role_type}}');
    }
}
