<?php

namespace app\modules\controllers;

use app\modules\models\Admin;
use Yii;
use yii\web\Controller;

class ManageController extends Controller
{
    public function actionMailChangePass()
    {
        $this->layout = false;
        $model = new Admin;
        $request = Yii::$app->request;

        if($request->isPost){
            $post = Yii::$app->request->post();

            if($model->changePass($post)){
                Yii::$app->session->setFlash('info', '密码修改成功');
                return $this->redirect(['public/login']);
            }else{
                Yii::$app->session->setFlash('info', '密码修改失败');
                return $this->redirect(['public/login']);
            }
        }else{
            $time = $request->get('timestamp');
            $token = $request->get('token');
            $adminUser = $request->get('adminUser');
            $buildToken = $model->createToken($adminUser, $time);

            // 判断验证令牌是否伪造
            if(!$token == $buildToken){
                Yii::$app->session->setFlash('info', '验证令牌无效,请重新进行找回密码操作');
                return $this->redirect(['public/login']);
            }

            // 判断验证时间是否失效
            if(time() - $time > 300){
                Yii::$app->session->setFlash('info', '验证时间失效,请在规定的时间内进行找回密码操作');
                return $this->redirect(['public/login']);
            }

            $model->adminUser = $adminUser;
            return $this->render('mail-change-pass', compact('model'));
        }
    }

    public function actionManagers()
    {
        $this->layout = false;
        $managers = Admin::find()->all();

        return $this->render('managers', ['managers' => $managers]);
    }
}

