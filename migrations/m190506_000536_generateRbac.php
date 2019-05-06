<?php

use yii\db\Migration;

/**
 * Class m190506_000536_generateRbac
 */
class m190506_000536_generateRbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $componentRbac = Yii::createObject(array(
            'class' => \app\modules\rbac\components\RbacComponent::class,
            'app' => Yii::$app
        ));
        $componentRbac->genRbac();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $componentRbac = Yii::createObject(array(
            'class' => \app\modules\rbac\components\RbacComponent::class,
            'app' => Yii::$app
        ));
        $componentRbac->cleanRbac();

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_000536_generateRbac cannot be reverted.\n";

        return false;
    }
    */
}
