<?php

namespace app\modules\controllers;

use app\modules\models\Category;
use yii\web\Controller;
use Yii;
use yii\data\Pagination;

class CategoryController extends Controller
{
    public function actionList()
    {
        $this->layout = 'main';
        $model = Category::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['category'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $categories = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('list', compact('categories', 'pager'));
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

    public function actionUpdate()
    {
        $this->layout = 'main';
        $cateId = Yii::$app->request->get('cateId');
        $model = Category::find()->where(['=', 'cateId', $cateId])->one();
        $list = $model->getOptions();
        $list[0] = "顶级分类";
        ksort($list);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }

        return $this->render('add', compact('list', 'model'));
    }

    public function actionDelete()
    {
        $cateId = Yii::$app->request->get('cateId');
        $model = Category::find()->where(['cateId' => $cateId])->one();

        try {
            if (empty($model)) {
                throw new \Exception("删除数据不存在,请刷新页面");
            }

            if ($model->delete()) {
                Yii::$app->session->setFlash('info', '删除数据成功');
            } else {
                throw new \Exception("删除数据成功");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('info', $e->getMessage());
        }

        return $this->redirect(['category/list']);
    }
}
