<?php

use yii\db\Migration;

/**
 * Class m190428_175344_addData
 */
class m190428_175344_addData extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'users',
            array('id', 'email', 'name', 'password_hash', 'token', 'auth_key'),
            array(
                array(1, 'admin@test.ru', 'admin', $this->getHash('123456'), $this->getToken(), 'admin_ak'),
                array(2, 'user@test.ru', 'Иван', $this->getHash('123456'), $this->getToken(), 'admin_ak'),
            )
        );


        $this->batchInsert(
            'activities',
            array('id', 'user_id', 'title', 'description', 'startDate', 'endDate', 'email', 'isBlocking', 'needNotification'),
            array(
                array(1, 1, 'Событие 1', 'Описание события 1', '2019-04-29', '2019-05-1', 'test@test.ru', 1, 1),
                array(2, 1, 'Событие 2', 'Описание события 2', '2019-05-02', null, 'test@test.ru', 1, 0),
                array(3, 2, 'Событие 3', 'Описание события 3', '2019-04-29', null, '', 0, 0),
                array(4, 2, 'Событие 4', 'Описание события 4', '2019-04-30', null, '', 0, 0),
                array(5, 1, 'Событие 5', 'Описание события 5', '2019-04-29', null, '', 0, 0),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('activities');
        $this->delete('users');
    }

    public function getHash($string)
    {
        return Yii::$app->security->generatePasswordHash($string);
    }

    public function getToken()
    {
        return Yii::$app->security->generateRandomString();
    }
}
