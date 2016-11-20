<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public $id;
    public $authKey;
    public $accessToken;
    public $rePass;
    public $loginName;
    public $rememberMe = true;

    public static function tableName()
    {
        return "{{%user}}";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public function rules()
    {
        return [
            ['userName', 'required', 'message' => '用户名称不能为空', 'on' => ['login', 'reg', 'reg-by-mail']],
            ['userPass', 'required', 'message' => '用户密码不能为空', 'on' => ['login', 'reg', 'reg-by-mail']],
            ['userEmail', 'required', 'message' => '用户邮箱不能为空', 'on' => ['reg', 'reg-by-mail']],
            ['userEmail', 'email', 'message' => '用户邮箱格式不正确', 'on' => ['reg', 'reg-by-mail']],
            ['rePass', 'required', 'message' => '确认密码不能为空', 'on' => ['reg']],
            ['rePass', 'compare', 'compareAttribute' => 'userPass', 'message' => '两次密码输入不一致', 'on' => ['reg']],
            ['userPass', 'validatePass', 'on' => ['login']],
        ];
    }

    public function validatePass()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where('userName = :user and userPass = :pass',
                [':user' => $this->userName, ':pass' => $this->userPass])->one();

            if (is_null($data)) {
                $this->addError('userPass', '用户名或密码错误');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'userName' => '用户名称',
            'userPass' => '用户密码',
            'userEmail' => '用户邮箱',
            'rePass' => '确认密码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['userId' => 'userId']);
    }

    public function regByMail($data)
    {
        $data['User']['userName'] = 'yii2_' . uniqid();
        $data['User']['userPass'] = uniqid();
        $data['User']['userEmail'] = $data['userEmail'];
        $this->scenario = 'reg-by-mail';

        if ($this->load($data)) {
            $params = [
                'userName' => $data['User']['userName'],
                'userPass' => $data['User']['userPass'],
            ];
            $mailer = \Yii::$app->mailer->compose('createuser', $params);
            $mailer->setFrom("luisedware@163.com");
            $mailer->setTo($data['userEmail']);
            $mailer->setSubject('Yii2 商城-新建用户');

            if ($mailer->send() && $this->reg($data, 'reg-by-mail')) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function reg($data, $scenario = 'reg')
    {
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->createdAt = time();
            $this->userPass = md5($this->userPass);

            if ($this->save(false)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login($data)
    {
        $this->scenario = 'login';
        $params['User']['userName'] = $data['userName'];
        $params['User']['userPass'] = $data['userPass'];

        if ($this->load($params) ) {

            $lifeTime = $this->rememberMe ? 24 * 3600 : 0;
            $session = \Yii::$app->session;
            session_set_cookie_params($lifeTime);

            $session['loginName'] = $data['userName'];
            $session['isLogin'] = 1;

            return (bool)$session['isLogin'];
        } else {
            var_dump($this->getValidators());
            exit;
            return false;
        }

    }
}
