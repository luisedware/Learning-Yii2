<?php

namespace app\controllers;

use app\models\Address;
use Yii;
use app\models\User;

class AddressController extends CommonController
{
    public function actionAdd()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }

        $loginName = Yii::$app->session['loginName'];
        $userId = User::find()->where('userName = :name or userEmail = :email',
            [':name' => $loginName, ':email' => $loginName])->one()->userId;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['userId'] = $userId;
            $post['address'] = $post['address1'] . $post['address2'];
            $data['Address'] = $post;
            $model = new Address();
            $model->load($data);
            $model->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDel()
    {
        if (Yii::$app->session['isLogin'] != 1) {
            return $this->redirect(['member/auth']);
        }

        $loginName = Yii::$app->session['loginName'];
        $userId = User::find()->where('userName = :name or userEmail = :email',
            [':name' => $loginName, ':email' => $loginName])->one()->userId;
        $addressId = Yii::$app->request->get('addressId');
        if (!Address::find()->where(['userId' => $userId, 'addressId' => $addressId])->one()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        Address::deleteAll(['addressId' => $addressId]);
        return $this->redirect(Yii::$app->request->referrer);
    }
}