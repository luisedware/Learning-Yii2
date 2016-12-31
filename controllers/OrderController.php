<?php

namespace app\controllers;

class OrderController extends CommonController
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
