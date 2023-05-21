<?php

use yii\db\Migration;

/**
 * Class m230521_112230_init_rbac
 */
class m230521_112230_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Создание ролей
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        $userRole = $auth->createRole('user');
        $auth->add($userRole);

        $hiddenRole = $auth->createRole('hidden');
        $auth->add($hiddenRole);

        // Создание разрешений
        $createAllPermission = $auth->createPermission('createAll');
        $auth->add($createAllPermission);

        $updateAllPermission = $auth->createPermission('updateAll');
        $auth->add($updateAllPermission);

        $votePermission = $auth->createPermission('vote');
        $auth->add($votePermission);

        $viewYourAnswerPermission = $auth->createPermission('viewYourAnswer');
        $auth->add($viewYourAnswerPermission);

        // Связывание разрешений с ролями
        $auth->addChild($adminRole, $createAllPermission);
        $auth->addChild($adminRole, $updateAllPermission);
        $auth->addChild($userRole, $votePermission);
        $auth->addChild($hiddenRole, $viewYourAnswerPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}