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
                array(1, 'admin@test.ru', 'admin', 'admin_hash', 'admin_token', 'admin_ak'),
                array(2, 'user2@test.ru', 'Иван', 'admin_hash', 'admin_token', 'admin_ak'),
                array(3, 'user3@test.ru', 'Петр', 'admin_hash', 'admin_token', 'admin_ak'),
                array(4, 'user4@test.ru', 'Аркадий', 'admin_hash', 'admin_token', 'admin_ak'),
                array(5, 'user5@test.ru', 'Герман', 'admin_hash', 'admin_token', 'admin_ak'),
            )
        );


        $this->batchInsert(
            'activities',
            array('id', 'user_id', 'title', 'description', 'startDate', 'endDate', 'email', 'isBlocking', 'needNotification'),
            array(
                array(1, 1, 'Событие 1', 'Описание события 1', '2019-04-29', '2019-05-1', 'test@test.ru', 1, 1),
                array(2, 1, 'Событие 2', 'Описание события 2', '2019-05-02', null, 'test@test.ru', 1, 0),
                array(3, 3, 'Событие 3', 'Описание события 3', '2019-04-29', null, '', 0, 0),
                array(4, 2, 'Событие 4', 'Описание события 4', '2019-04-30', null, '', 0, 0),
                array(5, 3, 'Событие 5', 'Описание события 5', '2019-04-29', null, '', 0, 0),
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190428_175344_addData cannot be reverted.\n";

        return false;
    }
    */
}
