<?php

namespace app\modules\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    const AK = "Ibb2T063qdVhr4w5SHMzjMbINMo3yPD0H1t0kbIL";
    const SK = "swoVmmS2xUQVFK-XB6mWPAkzIrtoWB2u6iPLmDj1";
    const DOMAIN = 'oisahwe1m.bkt.clouddn.com';
    const BUCKET = 'yiishoptest';

    public static function tableName()
    {
        return "{{shop_product}}";
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => '标题不能为空'],
            ['descr', 'required', 'message' => '描述不能为空'],
            ['cateId', 'required', 'message' => '分类不能为空'],
            ['price', 'required', 'message' => '单价不能为空'],
            [['price', 'salePrice'], 'number', 'min' => 0.01, 'message' => '价格必须为正确的数值'],
            ['num', 'integer', 'min' => 0, 'message' => '库存必须是数字'],
            [['isSale', 'isHot', 'pics', 'isTui'], 'safe'],
            [['cover'], 'required'],
        ];
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

    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }

        return false;
    }
}
