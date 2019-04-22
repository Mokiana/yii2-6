<?php

namespace app\controllers;

use app\base\controllers\BaseController;
use app\controllers\actions\ActivityCreateAction;
use app\controllers\actions\ActivityListAction;


class ActivityController extends BaseController
{
    public function actions()
    {
        return array(
            'create' => array(
                'class' => ActivityCreateAction::class,
            ),
            'index' => array(
                'class' => ActivityCreateAction::class,
            ),
            'list' => array(
                'class' => ActivityListAction::class,
            ),
        );
    }

}
