<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/9
 * Time: 11:22
 */
namespace backend\models;
use yii\db\ActiveRecord;

class AuthItem extends ActiveRecord{
    public function rules(){
        return[
            [['name','description'],'required'],
            [['name'],'unique'],
        ];
    }
    public function attributeLabels(){
        return[
            'name'=>'权限(路由)',
            'description'=>'简介',
        ];
    }
}