<?php

namespace app\controllers;

class ProductController extends CommonController
{
    public $layout = "layout";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDetail()
    {
        return $this->render('detail');
    }
}
