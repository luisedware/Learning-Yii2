<?php

namespace app\modules\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\models\Admin;
use yii\web\NotFoundHttpException;

class PublicController extends Controller
{
    public $layout = false;

    public function actionLogin()
    {
        $model = new Admin;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if ($model->login($post)) {
                return $this->redirect('index.php?r=admin/default/index');
            } else {
                Yii::$app->session->setFlash('info', '登录账号或密码错误');
                return $this->redirect(['public/login']);
            }

        } else {
            return $this->render('login', compact('model'));
        }
    }

    public function actionLogout()
    {
        Yii::$app->session->removeAll();

        if (!isset(Yii::$app->session['admin']['isLogin'])) {
            return $this->redirect(['public/login']);
        } else {
            return $this->goBack();
        }
    }

    public function actionSeekPassword()
    {
        $model = new Admin;
        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $request->post();
            if ($model->seekPass($post)) {
                Yii::$app->session->setFlash('info', '电子邮件已经发送成功,请查收');
            } else {
                Yii::$app->session->setFlash('info', '电子邮件发送失败');
            }
        }
        return $this->render('seek-password', compact('model'));
    }
}