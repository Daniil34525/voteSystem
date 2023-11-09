<?php

use yii\db\Migration;

/**
 * Class m230521_191904_add_access_token_to_hidden
 */
class m230521_191904_add_access_token_to_hidden extends Migration
{/**
 * {@inheritdoc}
 */
    public function safeUp()
    {
        $this->addColumn('hiddens', 'access_token', $this->integer()->unique()->after('code'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hiddens', 'access_token');
    }
}
