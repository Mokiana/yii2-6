<?php

use yii\db\Migration;

/**
 * Class m190428_171153_createTables
 */
class m190428_171153_createTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'activities',
            array(
                'id' =>  $this->primaryKey(),
                'user_id' =>  $this->integer()->notNull(),
                'title' => $this->string(100)->notNull(),
                'description' => $this->text(),
                'startDate' => $this->date()->notNull(),
                'endDate' => $this->date(),
                'email' => $this->string(150),
                'isBlocking' => $this->tinyInteger()->defaultValue(0),
                'needNotification' => $this->tinyInteger()->notNull()->defaultValue(0),
                'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            )
        );

        $this->createTable(
            'activity_files',
            array(
                'activity_id' => $this->integer()->notNull(),
                'file_path' => $this->string()->notNull(),
            )
        );

        $this->createTable(
            'users',
            array(
                'id' => $this->primaryKey(),
                'name' => $this->string(150)->notNull(),
                'email' => $this->string(200)->notNull(),
                'password_hash' => $this->string(300)->notNull(),
                'token' => $this->string(300),
                'auth_key' => $this->string(300),
                'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()
            )
        );

        $this->createIndex('userEmails', 'users', 'email', true);
        $this->createIndex('filesActivity', 'activity_files', 'activity_id', false);

        $this>$this->addForeignKey(
            'activityFilesFK',
            'activity_files',
            'activity_id',
            'activities',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'activityUserFK',
            'activities',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('activityUserFK', 'activities');
        $this->dropIndex('filesActivity', 'activity_files');
        $this->dropTable('activities');
        $this->dropTable('activity_files');
        $this->dropIndex('userEmails', 'users');
        $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190428_171153_createTables cannot be reverted.\n";

        return false;
    }
    */
}
