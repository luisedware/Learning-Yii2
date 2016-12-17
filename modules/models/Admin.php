<?php

namespace app\modules\models;

use yii\db\ActiveRecord;

class Admin extends ActiveRecord
{
    public $rememberMe = true;
    public $rePass;

    public static function tableName()
    {
        return "{{%admin}}";
    }

    public function attributeLabels()
    {
        return [
            'adminUser' => '管理员账号',
            'adminPass' => '管理员密码',
            'adminEmail' => '管理员邮箱',
            'rePass' => '确认密码',
        ];
    }

    public function rules()
    {
        return [
            [
                'adminUser',
                'required',
                'message' => '管理员账号不能为空',
                'on' => ['login', 'seek-pass', 'change-password', 'admin-add'],
            ],
            ['adminUser', 'unique', 'message' => '管理员账号已注册', 'on' => ['admin-add']],
            [
                'adminPass',
                'required',
                'message' => '管理员密码不能为空',
                'on' => ['login', 'change-password', 'admin-add', 'change-email'],
            ],
            ['adminPass', 'validatePass', 'on' => ['login', 'change-email']],
            ['rememberMe', 'boolean', 'on' => 'login'],
            ['adminEmail', 'required', 'message' => '电子邮箱不能为空', 'on' => ['seek-pass', 'admin-add', 'change-email']],
            ['adminEmail', 'email', 'message' => '电子邮箱格式不正确', 'on' => ['seek-pass', 'admin-add', 'change-email']],
            ['adminEmail', 'unique', 'message' => '电子邮箱格式已注册', 'on' => ['admin-add', 'change-email']],
            ['adminEmail', 'validateEmail', 'on' => 'seek-pass'],
            ['rePass', 'required', 'message' => '确认密码不能为空', 'on' => ['change-password', 'admin-add']],
            [
                'rePass',
                'compare',
                'compareAttribute' => 'adminPass',
                'message' => '两次密码输入不一致',
                'on' => ['change-password', 'admin-add'],
            ],
        ];
    }

    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where('adminUser = :user and adminPass = :pass',
                [':user' => $this->adminUser, ':pass' => md5($this->adminPass)])->one();
            if (is_null($data)) {
                $this->addError('adminPass', "用户名或密码错误");
            }
        }
    }

    public function validateEmail()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where('adminUser = :user and adminEmail = :email',
                [':user' => $this->adminUser, ':email' => $this->adminEmail])->one();
            if (is_null($data)) {
                $this->addError('adminEmail', "用户名或电子邮箱错误");
            }
        }
    }

    public function login($data)
    {
        $this->scenario = 'login';

        if ($this->load($data) && $this->validate()) {
            // 跨页使用 Session
            $lifeTime = $this->rememberMe ? 24 * 3600 : 0;
            $session = \Yii::$app->session;
            session_set_cookie_params($lifeTime);
            $session['admin'] = [
                'adminUser' => $this->adminUser,
                'isLogin' => 1,
            ];

            // 更新用户的登录时间
            $this->updateAll([
                'loginTime' => time(),
                'loginIP' => ip2long(\Yii::$app->request->userIP),
            ], 'adminUser = :user', [':user' => $this->adminUser]);

            return (bool)$session['admin']['isLogin'];
        } else {
            return false;
        }
    }

    public function seekPass($data)
    {
        $this->scenario = 'seek-pass';

        if ($this->load($data) && $this->validate()) {
            $time = time();
            $token = $this->createToken($data['Admin']['adminUser'], $time);
            $params = ['adminUser' => $data['Admin']['adminUser'], 'time' => $time, 'token' => $token];

            $mailer = \Yii::$app->mailer->compose('seekpass', $params);
            $mailer->setFrom("luisedware@163.com");
            $mailer->setTo($data['Admin']['adminEmail']);
            $mailer->setSubject("慕课商城-找回密码");

            if ($mailer->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function createToken($adminUser, $time)
    {
        return md5(md5($adminUser) . base64_encode(\Yii::$app->request->userIP) . md5($time));
    }

    public function changePass($data)
    {
        $this->scenario = "change-password";
        if ($this->load($data) && $this->validate()) {
            return $this->updateAll(
                ['adminPass' => md5($this->adminPass)],
                'adminUser = :user', [':user' => $this->adminUser]
            );
        } else {
            return false;
        }
    }

    public function reg($data)
    {
        $this->scenario = 'admin-add';
        if ($this->load($data) && $this->validate()) {
            $this->adminPass = md5($this->adminPass);
            // save 方法传值 false 不会对数据进行验证
            if ($this->save(false)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function changeEmail($data)
    {
        $this->scenario = 'change-email';

        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['adminEmail' => $this->adminEmail], 'adminUser = :user',
                [':user' => $this->adminUser]);
        }
        return false;
    }
}

