<?php

namespace app\controllers;

use app\base\controllers\BaseController;
use app\components\ActivityComponent;
use app\components\ActivityFileComponent;
use app\controllers\actions\ActivityCreateAction;
use app\controllers\actions\ActivityDetailAction;
use app\controllers\actions\ActivityEditAction;
use app\controllers\actions\ActivityListAction;
use app\models\ActivitySearch;
use app\modules\rbac\components\RbacComponent;


class ActivityController extends BaseController
{


//    public function actions()
//    {
//        $rbac = \Yii::createObject(array(
//            'class' => RbacComponent::class,
//            'app' => \Yii::$app,
//            'authManager' => \Yii::$app->authManager
//        ));
//
//        return array(
//            'create' => array(
//                'class' => ActivityCreateAction::class,
//                'name' => 'activity',
//                'fileComponent' => ActivityFileComponent::class,
//                'rbac' => $rbac
//            ),
////            'index' => array(
////                'class' => ActivityCreateAction::class,
////                'name' => 'activity',
////                'rbac' => $rbac,
////                'fileComponent' => ActivityFileComponent::class,
////            ),
//            'list' => array(
//                'class' => ActivityListAction::class,
//                'name' => 'activity'
//            ),
//            'detail' => array(
//                'class' => ActivityDetailAction::class,
//                'name' => 'activity',
//                'rbac' => $rbac,
//            ),
//            'edit' => array(
//                'class' => ActivityEditAction::class,
//                'name' => 'activity',
//                'rbac' => $rbac,
//            ),
//        );
//    }

    public function actionIndex(){

        $model=new ActivitySearch();
        $provider=$model->search(\Yii::$app->request->getQueryParams());
        return $this->render('index',['model'=>$model,'provider'=>$provider]);
    }
}
