<?php

namespace app\controllers;

use app\models\User;
use Yii;

/**
 * 用户管理控制器
 * @package app\controllers
 */
class MemberController extends CommonController
{
    /**
     * @return string
     */
    public function actionAuth()
    {
        $this->layout = "layout";
        $model = new User();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if ($model->login($post)) {
                return $this->goBack(Yii::$app->request->referrer);
            }
        }

        return $this->render('auth', compact($model));
    }

    /**
     * @return string
     */
    public function actionReg()
    {
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功');
            } else {
                Yii::$app->session->setFlash('info', '电子邮件发送失败');
            }
        }

        $this->layout = 'layout';
        return $this->render('auth', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('loginName');
        Yii::$app->session->remove('isLogin');
        if (!isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }
    }
}
