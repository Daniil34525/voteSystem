<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletin}}`.
 */
class m230407_132955_create_bulletin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bulletin}}',
            [
                'id' => $this->primaryKey()->comment('Код бюллетени'),
                'title' => $this->string()->notNull()->comment('Название'),
                //'bulletinList_id' => $this->integer()->comment('Список бюллетеней'),
                'created_at' => $this->integer()->notNull()->comment('Дата создания')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bulletin}}');
    }
}
