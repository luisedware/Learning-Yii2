<?php

namespace app\modules\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return "{{shop_product}}";
    }

    public function attributeLabels()
    {
        return [
            'cateId' => '商品分类',
            'title' => '商品名称',
            'descr' => '商品描述',
            'price' => '商品价格',
            'isHot' => '是否热卖',
            'isSale' => '是否促销',
            'salePrice' => '促销价格',
            'num' => '商品库存',
            'isOn' => '是否上架',
            'isTui' => '是否推荐',
            'cover' => '商品封面',
            'pics' => '商品图片',
        ];
    }
}
