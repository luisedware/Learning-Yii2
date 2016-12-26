<?php

namespace app\modules\controllers;

use app\modules\models\Category;
use app\modules\models\Product;
use yii\web\Controller;
use Yii;
use yii\data\Pagination;
use crazyfd\qiniu\Qiniu;

class ProductController extends Controller
{
    public function actionList()
    {
        $this->layout = 'main';
        $model = Product::find();
        $count = $model->count();
        $pageSize = 25;
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('products', compact('products', 'pager'));
    }

    public function actionAdd()
    {
        $this->layout = 'main';
        $product = new Product();
        $category = new Category();
        $options = $category->getOptions();
        unset($options[0]);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $pics = $this->upload();

            if (!$pics) {
                $product->addError('cover', '封面不能为空');
            } else {
                $post['Product']['cover'] = $pics['cover'];
                $post['Product']['pics'] = $pics['pics'];
            }

            if ($pics && $product->add($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            } else {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        return $this->render('add', compact('product', 'options'));
    }

    private function upload()
    {
        if ($_FILES['Product']['error']['cover'] > 0) {
            return false;
        }

        // 获取封面图片
        $uploader = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
        $key = uniqid();
        $uploader->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
        $cover = $uploader->getLink($key);

        // 获取商品图片
        $pics = [];

        if (isset($_FILES['Product']['tmp_name']['pics']) && !empty($_FILES['Product']['tmp_name']['pics'])) {
            foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                if ($_FILES['Product']['error']['pics'][$k] > 0) {
                    continue;
                }
                $key = uniqid();
                $uploader->uploadFile($file, $key);
                $pics[] = $uploader->getLink($key);
            }
            $pics = json_encode($pics);
        }

        return compact('cover', 'pics');
    }
}