<?php

namespace app\controllers;

use app\base\controllers\BaseController;
use app\components\ActivityFileComponent;
use app\controllers\actions\ActivityCreateAction;
use app\controllers\actions\ActivityDetailAction;
use app\controllers\actions\ActivityListAction;


class ActivityController extends BaseController
{
    public function actions()
    {
        return array(
            'create' => array(
                'class' => ActivityCreateAction::class,
                'name' => 'activity',
                'fileComponent' => ActivityFileComponent::class,
            ),
            'index' => array(
                'class' => ActivityCreateAction::class,
                'name' => 'activity',
                'fileComponent' => ActivityFileComponent::class,
            ),
            'list' => array(
                'class' => ActivityListAction::class,
                'name' => 'activity'
            ),
            'detail' => array(
                'class' => ActivityDetailAction::class,
                'name' => 'activity'
            ),
        );
    }
}
