<?php

namespace app\models;

use app\modules\models\Product;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%cart}}";
    }

    public function rules()
    {
        return [
            ['productId', 'required', 'message' => '商品 ID 不能为空'],
            ['productNum', 'required', 'message' => '商品提交数量不能为空'],
            ['price', 'required', 'message' => '商品价格不能为空'],
            ['userId', 'required', 'message' => '用户 ID 不能为空'],
            ['createdAt', 'required', 'message' => '用户 ID 不能为空'],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['productId' => 'productId']);
    }
}