<?php

namespace app\modules\controllers;

use app\modules\models\Category;
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
        $model = new Category();
        $list = $model->getOptions();
        $list[0] = "添加顶级分类";
        ksort($list);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }

        return $this->render('add', compact('list', 'model'));
    }
}
