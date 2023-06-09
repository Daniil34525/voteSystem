<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roleType}}`.
 */
class m230411_080202_create_role_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_types}}', [
            'id' => $this->primaryKey()->comment('Идентификтор роли'),
            'title' => $this->string()->notNull()->comment('Наименование роли'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role_types}}');
    }
}
