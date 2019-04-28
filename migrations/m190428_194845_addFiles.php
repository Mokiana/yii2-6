<?php

use yii\db\Migration;

/**
 * Class m190428_194845_addFiles
 */
class m190428_194845_addFiles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert(
            'activity_files',
            array('activity_id', 'file_path'),
            array(
                array(1, '/images/yii2_2_5cc0eb5d789d4.jpg'),
                array(1, '/images/yii2_5cc0eb5d78aee.jpg'),
                array(2, '/images/yii2_2_5cc0eb5d789d4.jpg'),
                array(2, '/images/yii2_5cc0eb5d78aee.jpg'),
                array(3, '/images/yii2_2_5cc0eb5d789d4.jpg'),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('activity_files');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190428_194845_addFiles cannot be reverted.\n";

        return false;
    }
    */
}
