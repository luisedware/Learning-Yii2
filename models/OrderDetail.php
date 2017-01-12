<?php

namespace app\models;

use app\modules\models\Product;
use yii\db\ActiveRecord;

class OrderDetail extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%order_detail}}";
    }

    public function rules()
    {
        return [
            [['productId', 'productNum', 'price', 'orderId', 'created'], 'required'],
        ];
    }

    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['productId' => 'productId']);
    }
}