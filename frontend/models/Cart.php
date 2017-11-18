<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/15
 * Time: 15:48
 */

namespace frontend\models;
use backend\models\Goods;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord{

    public function rules(){
        return[
            [['goods_id','amount'],'required']
        ];
    }
    public function getGoods(){
            /**
             * 第一个参数为要关联的字表模型类名称，
             *第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
             */
            return $this->hasOne(Goods::className(), ['id' => 'goods_id']);

    }
}