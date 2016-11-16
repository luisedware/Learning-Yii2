<?php

namespace app\controllers;

use yii\web\Controller;

class MemberController extends Controller
{

    public function actionAuth()
    {
        $this->layout = "layout";
        return $this->render('auth');
    }
}
