<?php

namespace app\modules\controllers;

use app\modules\models\Category;
use app\modules\models\Product;
use yii\web\Controller;
use Yii;
use yii\data\Pagination;

class ProductController extends Controller
{
    public function actionList()
    {
        $this->layout = 'main';

        return $this->render('products');
    }

    public function actionAdd()
    {
        $this->layout = 'main';
        $product = new Product();
        $category  = new Category();
        $options = $category->getOptions();
        unset($options[0]);

        return $this->render('add',compact('product','options'));
    }
}