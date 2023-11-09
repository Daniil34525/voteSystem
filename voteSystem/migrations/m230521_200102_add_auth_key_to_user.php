<?php

use yii\db\Migration;

/**
 * Class m230521_200102_add_auth_key_to_user
 */
class m230521_200102_add_auth_key_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'authKey', $this->integer()->unique()->after('password_hash'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'authKey');
    }
}
