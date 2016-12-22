<?php

namespace app\modules\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%category}}";
    }

    public function attributeLabels()
    {
        return [
            'parentId' => '上级分类',
            'title' => '分类名称',
        ];
    }

    public function rules()
    {
        return [
            ['parentId', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题名称不能为空'],
            ['createdAt', 'safe'],
        ];
    }

    public function add($data)
    {
        $data['Category']['createdAt'] = time();
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    public function getData()
    {
        $categories = self::find()->all();
        $categories = ArrayHelper::toArray($categories);

        return $categories;
    }

    public function getTree($categories, $pid = 0)
    {
        $tree = [];

        foreach ($categories as $cate) {
            if ($cate['parentId'] == $pid) {
                $tree[] = $cate;
                $tree = array_merge($tree, self::getTree($categories, $cate['cateId']));
            }
        }

        return $tree;
    }

    public function setPrefix($data, $p = '|-----')
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];

        while ($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['parentId'] != $val['parentId']) {
                    $num++;
                }
            }
            if (array_key_exists($val['parentId'], $prefix)) {
                $num = $prefix[$val['parentId']];
            }
            $val['title'] = str_repeat($p, $num) . $val['title'];
            $prefix[$val['parentId']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = [];

        foreach ($tree as $value) {
            $options[$value['cateId']] = $value['title'];
        }

        return $options;
    }
}
