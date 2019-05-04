<?php
/**
 * Created by PhpStorm.
 * User: geras
 * Date: 04.05.2019
 * Time: 23:43
 */

namespace app\modules\auth\components;


use app\models\Users;
use yii\base\Component;
use yii\web\Application;

class CreateUserComponent extends Component
{
    /**
     * @var Users
     */
    public $model;
    /**
     * @var $app Application|\yii\console\Application
     */
    public $app;


    /**
     * @return Users
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * @param $model Users
     * @return bool
     */
    public function createUser(&$model):bool{
        $model->password_hash=$this->hashPassword($model->password);
        $model->auth_key=$this->generateAuthKey();
        if($model->save()){
            return true;
        }
        return false;
    }


    private function generateAuthKey(){
        return $this->app->security->generateRandomString();
    }
    private function hashPassword($password){
        return $this->app->security->generatePasswordHash($password);
    }
}