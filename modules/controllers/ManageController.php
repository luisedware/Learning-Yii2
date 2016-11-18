<?php

namespace app\modules\controllers;

use app\modules\models\Admin;
use Yii;
use yii\data\Pagination;
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
        $this->layout = 'main';
        $model = Admin::find();
        $count = $model->count();
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => 50]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('managers', compact('managers', 'pager'));
    }

    public function actionReg()
    {
        $this->layout = 'main';
        $model = new Admin;

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            if($model->reg($post)){
                Yii::$app->session->setFlash('info', '添加成功');
            }else{
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }

        return $this->render('reg', compact('model'));
    }

    public function actionDelete()
    {
        $adminId = Yii::$app->request->get('adminId');
        if(empty($adminId)){
            $this->redirect(['manage/managers']);
        }

        $model = new Admin;
        if($model->deleteAll('adminId = :id', [':id' => $adminId])){
            Yii::$app->session->setFlash('info', '删除成功');
            $this->redirect(['manage/managers']);
        }
    }

    public function actionChangeEmail()
    {
        $this->layout = 'main';
        $model = Admin::find()->where('adminUser = :user',
            [':user' => Yii::$app->session['admin']['adminUser']])->one();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changeEmail($post)){
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }

        // 设置密码为空
        $model->adminPass = "";
        return $this->render('change-email', compact('model'));
    }

    public function actionChangePassword()
    {
        $this->layout = 'main';
        $model = Admin::find()->where('adminUser = :user',
            [':user' => Yii::$app->session['admin']['adminUser']])->one();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->changePass($post)){
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }

        $model->adminPass = '';
        $model->rePass = '';
        return $this->render('change-password', compact('model'));
    }
}

