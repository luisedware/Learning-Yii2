<?php

namespace app\modules\controllers;

use app\models\Category;
use yii\web\Controller;
use Yii;

class CategoryController extends Controller
{
    public function actionList()
    {
        $this->layout = 'main';
        return $this->render('list');
    }

    public function actionAdd()
    {
        $this->layout = 'main';
        $list = [];
        $model = new Category();
        return $this->render('add', compact('list', 'model'));
    }
}