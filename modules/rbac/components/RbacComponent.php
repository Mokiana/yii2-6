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
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager()
    {
        return $this->app->authManager;
    }

    public function genRbac()
    {
        $authManager = $this->getAuthManager();
        //Очистка всх правил, ролей, разрешений
        $authManager->removeAll();

        //Добавление ролей
        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');
        $authManager->add($admin);
        $authManager->add($user);


        $createActivity = $authManager->createPermission('createActivity');
        $createActivity->description='Создание событий';

        $viewAllActivity = $authManager->createPermission('viewAllActivity');
        $viewAllActivity ->description='Просмотр любых событий';

        $viewOwnActivity = $authManager->createPermission('viewOwnActivity');
        $viewOwnActivity->description='Просмотр своих событий';

        $viewOwnerRule = new ViewOwnActivity();
        $authManager->add($viewOwnerRule);
        $viewOwnActivity->ruleName=$viewOwnerRule->name;

        $authManager->add($createActivity);
        $authManager->add($viewAllActivity );
        $authManager->add($viewOwnActivity);



        $authManager->addChild($user,$createActivity);
        $authManager->addChild($user,$viewOwnActivity);
        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$viewAllActivity);

        $authManager->assign($user,7);
        $authManager->assign($admin,1);
    }


    public function canCreateActivity(){
        return $this->app->user->can('createActivity');
    }


    /**
     * @param int $ownerId
     * @return bool
     */
    public function canViewActivity(int $ownerId){
        if($this->app->user->can('viewAllActivity')){
            return true;
        }

        if($this->app->user->can('viewOwnActivity', array('ownerId' => $ownerId))){
            return true;
        }
        return false;
    }
}