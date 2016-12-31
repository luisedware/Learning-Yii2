<?php

namespace app\controllers;

use app\modules\models\Category;
use yii\web\Controller;

class CommonController extends Controller
{
    public function init()
    {
        $menu = Category::getMenu();
        $this->view->params['menu'] = $menu;
        $data = [];
        $data['products'] = [];
    }
}
