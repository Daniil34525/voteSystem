<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m230411_080249_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->comment('Идентификтор пользователя'),
            'name' => $this->string()->notNull()->comment('Имя пользователя'),
            'middle_name' => $this->string()->comment('Фамилия пользователя'),
            'last_name' => $this->string()->comment('Отчество пользователя'),
            'email' => $this->string()->notNull()->unique()->comment('E-mail адрес'),
            'phone' => $this->string()->notNull()->unique()->comment('Телефон'),
            'password_hash' => $this->string()->notNull()->comment('Хеш пароля'),
            'role_type_id' => $this->integer()->notNull()->comment('Роль пользователя'),
        ]);
        
        $this->addForeignKey(
            'fk_users_role_types_id',
            'users',
            'role_type_id',
            'role_types',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_role_types_id', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
