<?php

use yii\db\Migration;

/**
 * Class m230530_103458_add_default_value
 */
class m230530_103458_add_default_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('role_types', ['id' => 1, 'title' => 'Администратор']);
        $this->insert('role_types', ['id' => 2, 'title' => 'Участник']);
        $this->insert('role_types', ['id' => 3, 'title' => 'Аноним']);
        $this->insert('users', ['id' => 1, 'name' => 'admin', 'email' => 'bestVotings@gmail.com', 'password_hash' => '$argon2id$v=19$m=65536,t=4,p=1$SFhYOUU3ZWQ0Q3RNTlpOYQ$AP14qvK1kRuzfTrENPmelHXxNXpZKsppvxaUHeo73yg', 'role_type_id' => 1, 'access_token' => 'admin', 'authKey' => 'admin', 'phone' => '+79641548788']);
        $this->insert('voting_types', ['id' => 1, 'title' => 'Открытое']);
        $this->insert('voting_types', ['id' => 2, 'title' => 'Анонимное']);
        $this->insert('question_types', ['id' => 1, 'title' => 'Одиночный выбор']);
        $this->insert('question_types', ['id' => 2, 'title' => 'Множественный выбор']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['id' => 1]);
        $this->delete('voting_types', ['id' => 1]);
        $this->delete('voting_types', ['id' => 2]);
        $this->delete('voting_types', ['id' => 3]);
        $this->delete('role_types', ['id' => 1]);
        $this->delete('role_types', ['id' => 2]);
        $this->delete('question_types', ['id' => 1]);
        $this->delete('question_types', ['id' => 2]);
    }
}
