<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    const CREATE_ORDER = 0;
    const CHECK_ORDER = 100;
    const PAY_FAILED = 201;
    const PAY_SUCCESS = 202;
    const SEND = 220;
    const RECEIVED = 260;

    public static $status = [
        self::CREATE_ORDER => '订单初始化',
        self::CHECK_ORDER => '待支付',
        self::PAY_FAILED => '支付失败',
        self::PAY_SUCCESS => '等待发货',
        self::SEND => '已发货',
        self::RECEIVED => '订单完成',
    ];

    public static function tableName()
    {
        return "{{%order}}";
    }

    public function rules()
    {
        return [
            [['userId', 'status'], 'required', 'on' => ['add']],
            [['addressId', 'expressId', 'amount', 'status'], 'required', 'on' => ['mod']],
            ['expressNo', 'required', 'message' => '请输入快递单号', 'on' => 'send'],
            ['created', 'safe', 'on' => ['add']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'expressNo' => '快递单号',
        ];
    }
}