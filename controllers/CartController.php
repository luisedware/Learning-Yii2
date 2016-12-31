<?php

namespace app\controllers;

class CartController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = 'layout-without-navigation';
        return $this->render('index');
    }
}


