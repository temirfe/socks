<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionUpdate(){
        $auth = Yii::$app->authManager;
        //$roleAdmin=$auth->getRole('admin');

    }

    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        //$auth->removeAll();

        //roles
        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);

        $auth->assign($roleAdmin, 1);

        //permissions
        $p_userView = $auth->createPermission('userView');
        $p_userView->description = 'View a User';
        $auth->add($p_userView);

        $p_userIndex = $auth->createPermission('userIndex');
        $p_userIndex->description = 'open index page of user (list of users)';
        $auth->add($p_userIndex);

        //children
        $auth->addChild($roleAdmin, $p_userIndex);
        $auth->addChild($roleAdmin, $p_userView);
    }
}