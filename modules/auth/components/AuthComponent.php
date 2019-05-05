<?php
/**
 * Created by PhpStorm.
 * User: geras
 * Date: 04.05.2019
 * Time: 23:43
 */

namespace app\modules\auth\components;


use app\models\Users;
use app\modules\auth\models\UsersSignIn;
use yii\base\Component;
use yii\web\Application;

class AuthComponent extends Component
{
    /**
     * @var Users|UsersSignIn
     */
    public $model;
    /**
     * @var $app Application|\yii\console\Application
     */
    public $app;


    /**
     * @return Users|UsersSignIn
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

    /**
     * @param $model UsersSignIn
     * @return bool
     */
    public function authUser(&$model): bool {
        if($model->validate(array('email', 'password'))) {
            $userModel =  UsersSignIn::find()
                ->where(array('email' => $model->email))
                ->one();
            $passwordIsCorrect = $this->checkPassword($model->password, $userModel->password_hash);
            if($passwordIsCorrect) {
                return $this->app->user->login($userModel, 3600);
            }
            return false;
        }
        return false;
    }

    /**
     * @param $password
     * @param $hash
     * @return boolean
     */
    private function checkPassword($password, $hash)
    {
        return $this->app->security->validatePassword($password, $hash);
    }

    private function generateAuthKey(){
        return $this->app->security->generateRandomString();
    }
    private function hashPassword($password){
        return $this->app->security->generatePasswordHash($password);
    }
}