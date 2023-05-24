<?php

use yii\db\Migration;

/**
 * Class m230524_195146_create_trigger_users_hiddens_id_unique
 */
class m230524_195146_create_trigger_users_hiddens_id_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //USERS
        $triggerName = 'unique_users_id';
        $tableName = 'users';
        $sql = <<<SQL
CREATE FUNCTION trigger_unique_user_id()
RETURNS TRIGGER AS $$
DECLARE
    max_id INTEGER;
BEGIN
    IF (TG_OP = 'INSERT') THEN 
        SELECT MAX(ID) INTO max_id FROM HIDDENS;
        IF NEW.ID <= max_id THEN
            NEW.ID := max_id + 1;
        END IF;
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;
SQL;
        $this->execute($sql);

        $sql = <<<SQL
CREATE TRIGGER {$triggerName}
BEFORE INSERT ON {$tableName}
For each row 
EXECUTE procedure trigger_unique_user_id();
SQL;
        $this->execute($sql);

        //HIDDENS
        $triggerName = 'unique_hiddens_id';
        $tableName = 'hiddens';
        $sql = <<<SQL
CREATE FUNCTION trigger_unique_hidden_id()
RETURNS TRIGGER AS $$
DECLARE
    max_id INTEGER;
BEGIN
    IF (TG_OP = 'INSERT') THEN 
        SELECT MAX(ID) INTO max_id FROM USERS;
        IF NEW.ID <= max_id THEN
            NEW.ID := max_id + 1;
        END IF;
        RETURN NEW;
    END IF;
END;
$$ LANGUAGE plpgsql;
SQL;
        $this->execute($sql);

        $sql = <<<SQL
CREATE TRIGGER {$triggerName}
BEFORE INSERT ON {$tableName}
For each row 
EXECUTE procedure trigger_unique_hidden_id();
SQL;
        $this->execute($sql);
//
//        $sql = <<<SQL
//CREATE TRIGGER {$triggerName}
//AFTER INSERT ON {$tableName}
//BEGIN
//    IF NEW.ID <= SELECT MAX(ID) FROM USERS
//        THEN NEW.ID := max_id+1;
//    return NEW;
//END;
//SQL;
//        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $triggerName = 'unique_hiddens_id';
        $tableName = 'hiddens';
        $this->execute("DROP TRIGGER IF EXISTS {$triggerName} ON {$tableName}");

        $triggerName = 'unique_users_id';
        $tableName = 'users';
        $this->execute("DROP TRIGGER IF EXISTS {$triggerName} ON {$tableName}");

        $this->execute('DROP FUNCTION IF EXISTS trigger_unique_user_id();');
        $this->execute('DROP FUNCTION IF EXISTS trigger_unique_hidden_id();');
    }
}
