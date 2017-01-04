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

    public function actionMod()
    {
        $this->layout = 'main';
        $category = new Category();
        $options = $category->getOptions();
        $productId = Yii::$app->request->get('productId');
        $product = Product::find()->where('productId = :id', ['id' => $productId])->one();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $uploader = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
            if ($_FILES['Product']['error']['cover'] == 0) {
                $key = uniqid();
                $uploader->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
                $post['Product']['cover'] = $uploader->getLink($key);
            }

            $pics = [];
            if (!empty($_FILES['Product']['tmp_name']['pics'])) {
                foreach ($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
                    if ($_FILES['Product']['error']['pics'][$k] > 0) {
                        continue;
                    }
                    $key = uniqid();
                    $uploader->uploadFile($file, $key);
                    $pics[] = $uploader->getLink($key);
                }
            }
            
            $post['Product']['pics'] = json_encode(array_merge((array)json_decode($product->pics, true), $pics));
            
            if ($product->load($post) && $product->save(false)) {
                Yii::$app->session->setFlash('info', '修改商品成功');
            }else{
                Yii::$app->session->setFlash('info', '修改商品失败');
            }
        }

        return $this->render('add', compact('product', 'options'));
    }

    public function actionDel()
    {
        if (Yii::$app->request->isGet) {
            $productId = Yii::$app->request->get('productId');
            $product = Product::find()->where(['productId' => $productId])->one();

            if ($product->delete()) {
                Yii::$app->session->setFlash('info', '删除商品成功');
            } else {
                Yii::$app->session->setFlash('info', '删除商品失败');
            }

            return $this->redirect(['product/list']);
        }
    }

    public function actionOn()
    {
        if (Yii::$app->request->isGet) {
            $productId = Yii::$app->request->get('productId');
            $product = Product::find()->where(['productId' => $productId])->one();

            $product->isOn = 1;
            if ($product->save()) {
                Yii::$app->session->setFlash('info', '上架商品成功');
            } else {
                Yii::$app->session->setFlash('info', '上架商品失败');
            }

            return $this->redirect(['product/list']);
        }
    }

    public function actionOff()
    {
        if (Yii::$app->request->isGet) {
            $productId = Yii::$app->request->get('productId');
            $product = Product::find()->where(['productId' => $productId])->one();

            $product->isOn = 0;
            if ($product->save()) {
                Yii::$app->session->setFlash('info', '下架商品成功');
            } else {
                Yii::$app->session->setFlash('info', '下架商品失败');
            }

            return $this->redirect(['product/list']);
        }
    }

    public function actionRemove()
    {

    }
}