<?php

namespace app\controllers;

use yii\web\Controller;

class ProductController extends Controller
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
