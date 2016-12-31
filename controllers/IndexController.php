<?php

namespace app\controllers;

class IndexController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = 'layout-without-navigation';
        return $this->render('index');
    }
}
