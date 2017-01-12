<?php

namespace app\controllers;

use app\models\Address;
use app\models\Cart;
use app\models\Order;
use app\models\OrderDetail;
use app\models\User;
use app\modules\models\Product;
use Yii;

class OrderController extends CommonController
{
    public $layout = false;

    public function actionIndex()
    {
        $this->layout = "layout";
        return $this->render('index');
    }

    public function actionCheck()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }

        $orderId = Yii::$app->request->get('orderId');
        $status = Order::find()->where(['orderId' => $orderId])->one()->status;
        if ($status != Order::CREATE_ORDER && $status != Order::CHECK_ORDER) {
            return $this->redirect(['order/index']);
        }
        $where = 'userName = :name or userEmail = :email';
        $value = [':name' => Yii::$app->session['loginName'], ':email' => Yii::$app->session['loginName']];
        $userId = User::find()->where($where, $value);

        $details = OrderDetail::find()->with('product')->where(['orderId' => $orderId])->asArray()->all();
        $addresses = Address::find()->where('userId = :uid', [':uid' => $userId])->asArray()->all();
        $express = Yii::$app->params['express'];
        $expressPrice = Yii::$app->params['expressPrice'];
        $this->layout = 'layout-without-navigation';

        return $this->render('check', compact('addresses', 'details', 'express', 'expressPrice'));
    }

    public function actionAdd()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $orderModel = new Order();
                $orderModel->scenario = 'add';
                $userName = Yii::$app->session['loginName'];
                $userModel = User::find()->where('userName = :userName or userEmail = :userEmail',
                    [':userName' => $userName, ':userEmail' => $userName])->one();

                if (!$userModel) {
                    throw new \Exception("没有找到登录用户");
                }

                $userId = $userModel->userId;
                $orderModel->userId = $userId;
                $orderModel->status = Order::CREATE_ORDER;
                $orderModel->created = time();
                if (!$orderModel->save()) {
                    throw new \Exception("订单生成失败");
                }

                $orderId = $orderModel->getPrimaryKey();
                foreach ($post['OrderDetail'] as $product) {
                    $model = new OrderDetail();
                    $product['orderId'] = $orderId;
                    $product['created'] = time();
                    $data['OrderDetail'] = $product;

                    if (!$model->add($data)) {
                        throw new \Exception("订单详情生成失败");
                    }
                    Cart::deleteAll('productId = :pid', [':pid' => $product['productId']]);
                    Product::updateAllCounters(['num' => -$product['productNum']], 'productId = :pid',
                        [':pid' => $product['productId']]);
                }
                $transaction->commit();

                return $this->redirect(['order/check', 'orderId' => $orderId]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('info', $e->getMessage() . $e->getFile() . $e->getLine());

            return $this->redirect(['cart/index']);
        }

    }
}
