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
    public $name;
    public function rules(){
        return[
            [['name','description'],'required'],
//            [['name'],'unique'],
            ['name','validateName']
        ];
    }
    public function validateName(){
        $auth = \yii::$app->authManager;
        $model=$auth->getPermission($this->name);
        if($model){
            $this->addError('name','权限已存在');
        }
    }
    public function attributeLabels(){
        return[
            'name'=>'权限(路由)',
            'description'=>'简介',
        ];
    }

}