<?php

namespace app\modules\controllers;

use app\models\Profile;
use app\models\User;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class UserController extends Controller
{
    public function actionUsers()
    {
        $model = User::find()->joinWith('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();

        $this->layout = 'main';
        return $this->render('users', compact('users', 'pager'));
    }

    public function actionReg()
    {
        $this->layout = 'main';
        $model = new User;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            } else {
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }

        $model->userPass = '';
        $model->rePass = '';

        return $this->render('reg', ['model' => $model]);
    }

    public function actionDelete()
    {
        $userId = (int)Yii::$app->request->get('userId');
        $trans = Yii::$app->db->beginTransaction();
        try {
            if (empty($userId)) {
                throw new \Exception();
            }

            if ($obj = Profile::find()->where('userId = :id', [':id' => $userId])->one()) {
                $res = Profile::deleteAll('userId = :id', [':id' => $userId]);

                if (empty($res)) {
                    throw new \Exception();
                }
            }

            if (!User::deleteAll('userId = :id', [':id' => $userId])) {
                throw new \Exception();
            }

            Yii::$app->session->setFlash('info', '删除成功');
            $trans->commit();
            return $this->redirect(['user/users']);
        } catch (\Exception $e) {
            if (Yii::$app->db->getTransaction()) {
                $trans->rollBack();
            }
        }
    }
}
