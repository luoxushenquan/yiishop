<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 14:20
 */
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsIntro extends ActiveRecord{
    public function rules(){
        return[
            ['content','required'],
//            ['logo','file','extensions'=>['jpg','png','gif','jpeg'],'skipOnEmpty'=>false],
        ];
    }
    public function attributeLabels(){
        return[
            'content'=>'商品详情',
        ];
    }
}