<?php

namespace app\controllers;

use app\models\Order;
use app\models\User;
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
        $this->layout = 'layout-without-navigation';
        return $this->render('check');
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
                    throw new \Exception();
                }

                $userId = $userModel->userId;
                $orderModel->userId = $userId;
                $orderModel->status = Order::CREATE_ORDER;
                if (!$orderModel->save()) {
                    throw new \Exception();
                }

                $orderId = $orderModel->getPrimaryKey();
            }
        } catch (\Exception $e) {

        }
    }
}
