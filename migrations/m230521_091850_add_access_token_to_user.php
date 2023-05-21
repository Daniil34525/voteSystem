<?php

use yii\db\Migration;

/**
 * Class m230521_091850_add_access_token_to_user
 */
class m230521_091850_add_access_token_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'access_token', $this->string()->unique()->after('password_hash'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'access_token');
    }
}
