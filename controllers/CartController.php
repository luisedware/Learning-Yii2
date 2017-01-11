<?php

namespace app\controllers;

use app\models\Cart;
use app\modules\models\Product;
use Yii;
use app\models\User;

class CartController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = 'layout-without-navigation';
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $userId = User::find()->where(['userName' => Yii::$app->session['loginName']])->one()->userId;
        $carts = Cart::find()->where(['userId' => $userId])->with('product')->all();

        return $this->render('index', compact('carts'));
    }

    public function actionAdd()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $productId = 0;
        $userId = User::find()->where(['userName' => Yii::$app->session['loginName']])->one()->userId;

        // 通过商品详情页提交
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $productId = Yii::$app->request->post()['productId'];
            $num = Yii::$app->request->post()['productNum'];
            $data['Cart'] = $post;
            $data['Cart']['userId'] = $userId;
        }

        // 通过商品分类页提交
        if (Yii::$app->request->isGet) {
            $productId = Yii::$app->request->get('productId');
            $model = Product::find()->where(['productId' => $productId])->one();
            $price = $model->isSale ? $model->salePrice : $model->price;
            $num = 1;
            $data['Cart'] = [
                'productId' => $productId,
                'productNum' => $num,
                'price' => $price,
                'userId' => $userId,
            ];
        }

        // 判断购物车当中是否存在相同的商品
        if (!$model = Cart::find()->where(['productId' => $productId, 'userId' => $userId])->one()) {
            $model = new Cart;
        } else {
            $data['Cart']['productNum'] = $model->productNum + $num;
        }
        $data['Cart']['createdAt'] = time();

        $model->load($data);
        $model->save(false);

        return $this->redirect(['cart/index']);
    }

    public function actionMod()
    {
        $cartId = Yii::$app->request->get('cartId');
        $productNum = Yii::$app->request->get('productNum');
        Cart::updateAll(['productNum' => $productNum], ['cartId' => $cartId]);
    }

    public function actionDel()
    {
        $cartId = Yii::$app->request->get('cartId');
        Cart::deleteAll('cartId = :cid', [':cid' => $cartId]);
        return $this->redirect(['cart/index']);
    }
}


