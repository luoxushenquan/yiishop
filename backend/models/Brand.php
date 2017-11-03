<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/3
 * Time: 14:29
 * id	primaryKey
name	varchar(50)	名称
intro	text	简介
logo	varchar(255)	LOGO图片
sort	int(11)	排序
status	int(2)	状态(-1删除 0隐藏 1正常)
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord{
    public $imgFile;//图片属性
    public function rules(){
        return[
            [['name','intro','sort','status'],'required'],
            ['imgFile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>false],

        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'品牌名',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态',
            'imgFile'=>'logo',
        ];
    }
}