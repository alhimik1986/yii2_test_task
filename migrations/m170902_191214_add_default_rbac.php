<?php

use yii\db\Migration;
use yii\rbac\DbManager;

class m170902_191214_add_default_rbac extends Migration
{
    public function safeUp()
    {
        $authManager = new DbManager;
        $authManager->init();

        // Создаем роли
        $admin = $authManager->createRole('admin');
        $admin->description = 'Админ';
        $authManager->add($admin);

        $manager = $authManager->createRole('manager');
        $manager->description = 'Менеджер';
        $authManager->add($manager);

        $user = $authManager->createRole('user');
        $user->description = 'Пользователь';
        $authManager->add($user);

        // Создаем правило
        $authorRule = new \app\modules\news\rbac\AuthorRule;
        $authManager->add($authorRule);

        // Создаем права
        $viewNewsPermit = $authManager->createPermission('viewNews');
        $viewNewsPermit->description = 'Просматривать новости';
        $authManager->add($viewNewsPermit);

        $createNewsPermit = $authManager->createPermission('createNews');
        $createNewsPermit->description = 'Создавать новости';
        $authManager->add($createNewsPermit);

        $editNewsPermit = $authManager->createPermission('editNews');
        $editNewsPermit->description = 'Редактировать новости';
        $authManager->add($editNewsPermit);

        $deleteNewsPermit = $authManager->createPermission('deleteNews');
        $deleteNewsPermit->description = 'Удалять новости';
        $authManager->add($deleteNewsPermit);

        $editOwnNewsPermit = $authManager->createPermission('editOwnNews');
        $editOwnNewsPermit->description = 'Редактировать свои новости';
        $editOwnNewsPermit->ruleName = $authorRule->name;
        $authManager->add($editOwnNewsPermit);

        $deleteOwnNewsPermit = $authManager->createPermission('deleteOwnNews');
        $deleteOwnNewsPermit->description = 'Удалять свои новости';
        $deleteOwnNewsPermit->ruleName = $authorRule->name;
        $authManager->add($deleteOwnNewsPermit);

        // Присоединяем права к ролям
        $authManager->addChild($admin, $viewNewsPermit);
        $authManager->addChild($admin, $createNewsPermit);
        $authManager->addChild($admin, $editNewsPermit);
        $authManager->addChild($admin, $deleteNewsPermit);

        $authManager->addChild($manager, $viewNewsPermit);
        $authManager->addChild($manager, $createNewsPermit);
        $authManager->addChild($manager, $editOwnNewsPermit);
        $authManager->addChild($manager, $deleteOwnNewsPermit);

        // Присоединяю роли пользователям
        $authManager->assign($admin, 1);
        $authManager->assign($manager, 2);
        $authManager->assign($user, 3);
    }

    public function safeDown()
    {
        $authManager = new DbManager;
        $authManager->init();

        $authManager->remove($authManager->getRole('admin'));
        $authManager->remove($authManager->getRole('manager'));
        $authManager->remove($authManager->getRole('user'));
        $authManager->remove($authManager->getPermission('viewNews'));
        $authManager->remove($authManager->getPermission('createNews'));
        $authManager->remove($authManager->getPermission('editNews'));
        $authManager->remove($authManager->getPermission('deleteNews'));
        $authManager->remove($authManager->getPermission('editOwnNews'));
        $authManager->remove($authManager->getPermission('deleteOwnNews'));
        $authorRule = new \app\rbac\news\AuthorRule;
        $authManager->remove($authorRule);
        /*
        $authManager->removeAllRules();
        $authManager->removeAllPermissions();
        $authManager->removeAllRoles();
        */
    }
}
