<?php

namespace app\controllers;

use yii\web\Controller;

class OrderController extends Controller
{
    public $layout = false;

    public function actionIndex()
    {
        $this->layout = "layout";
        return $this->render('index');
    }

    public function actionCheck()
    {
        $this->layout = 'layout-without-navigation';
        return $this->render('check');
    }
}
