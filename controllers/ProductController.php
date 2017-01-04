<?php

namespace app\controllers;

use app\modules\models\Product;
use yii\data\ActiveDataProvider;

class ProductController extends CommonController
{
    public $layout = "layout";

    public function actionIndex()
    {
        $query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        $pagination = $dataProvider->getPagination();
        $products = $dataProvider->getModels();

        return $this->render('index', compact('pagination', 'products'));
    }

    public function actionDetail()
    {
        return $this->render('detail');
    }
}
