<?php

namespace app\models;

use Yii;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string $token
 * @property string $auth_key
 * @property string $date_created
 */
class Users extends UsersBase
{
    public $password;

    public function rules()
    {

        return array_merge(
            parent::rules(),
            array(
                ['password','string','min' => 4],
                ['email','email'],
                ['email','unique'],
            )
        );
    }
}
