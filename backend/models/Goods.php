<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 14:05
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord{
    public function rules(){
        return[
            [['logo','name','goods_category_id','brand_id','market_price','shop_price','stock','is_on_sale','sort'],'required'],
            [['market_price','shop_price','stock','sort'],'integer']

        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'商品名称',
            'logo'=>'logo',
            'goods_category_id'=>'商品分类',
            'brand_id'=>'商品品牌',
            'market_price'=>'市场价格',
            'shop_price'=>'商品价格',
            'stock'=>'库存',
            'is_on_sale'=>'商品状态',
            'sort'=>'排序',


        ];
    }
}