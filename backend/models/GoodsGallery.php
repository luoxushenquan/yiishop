<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 11:38
 */
namespace backend\models;
use yii\db\ActiveRecord;

class GoodsGallery extends ActiveRecord{
    public function rules(){
        return[
            ['path','required'],
//            ['logo','file','extensions'=>['jpg','png','gif','jpeg'],'skipOnEmpty'=>false],
        ];
    }
    public function attributeLabels(){
        return[
            'path'=>'相册添加',
        ];
    }
}