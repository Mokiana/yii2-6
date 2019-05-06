<?php

namespace app\modules\rbac\components;


use app\rules\ViewOwnActivity;
use yii\base\Component;
use yii\web\Application;

class RbacComponent extends Component
{
    /**
     * @var $app Application|\yii\console\Application
     */
    public $app;

    /**
     * @var $authManager \yii\rbac\ManagerInterface
     */
    public $authManager;

    /**
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager()
    {
        return $this->authManager;
    }

    public function genRbac()
    {
        $authManager = $this->getAuthManager();
        //Очистка всх правил, ролей, разрешений
        $this->cleanRbac();

        //Добавление ролей
        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');
        $authManager->add($admin);
        $authManager->add($user);


        $createActivity = $authManager->createPermission('createActivity');
        $createActivity->description = 'Создание событий';

        $viewAllActivity = $authManager->createPermission('viewAllActivity');
        $viewAllActivity->description = 'Просмотр любых событий';

        $viewOwnActivity = $authManager->createPermission('viewOwnActivity');
        $viewOwnActivity->description = 'Просмотр своих событий';

        $editAllActivities = $authManager->createPermission('editAllActivities');
        $editAllActivities->description = 'Редактирование событий';

        $editOwnActivities = $authManager->createPermission('editOnwActivities');
        $editOwnActivities->description = 'Редактирование своих событий';

        $viewOwnerRule = new ViewOwnActivity();
        $authManager->add($viewOwnerRule);
        $viewOwnActivity->ruleName = $viewOwnerRule->name;
        $editOwnActivities->ruleName = $viewOwnerRule->name;

        $authManager->add($createActivity);
        $authManager->add($viewAllActivity);
        $authManager->add($viewOwnActivity);
        $authManager->add($editAllActivities);
        $authManager->add($editOwnActivities);


        $authManager->addChild($user, $createActivity);
        $authManager->addChild($user, $viewOwnActivity);
        $authManager->addChild($user, $editOwnActivities);

        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $viewAllActivity);
        $authManager->addChild($admin, $editAllActivities);

        $authManager->assign($user, 2);
        $authManager->assign($admin, 1);
    }

    public function cleanRbac()
    {
        $authManager = $this->getAuthManager();
        $authManager->removeAll();
    }


    public function canCreateActivity()
    {
        return $this->app->user->can('createActivity');
    }


    /**
     * @param int $ownerId
     * @return bool
     */
    public function canViewActivity(int $ownerId)
    {
        if ($this->canViewAllActivities()) {
            return true;
        }

        return $this->canViewOwnActivities($ownerId);
    }

    public function canViewAllActivities()
    {
        return $this->app->user->can('viewAllActivity');
    }

    public function canViewOwnActivities($ownerId)
    {
        return $this->app->user->can('viewOwnActivity', array('ownerId' => $ownerId));
    }

    /**
     * @param int $ownerId
     * @return bool
     */
    public function canEditActivity(int $ownerId)
    {
        if ($this->canEditAllActivities()) {
            return true;
        }

        return $this->canEditOwnActivities($ownerId);
    }

    public function canEditAllActivities()
    {
        return $this->app->user->can('editAllActivities');
    }

    public function canEditOwnActivities(int $ownerId)
    {
        return $this->app->user->can('editOnwActivities', array('ownerId' => $ownerId));
    }
}