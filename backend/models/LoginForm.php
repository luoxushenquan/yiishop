<?php
namespace backend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password_hash;
    public $remember ;
//    public $code;
    public function rules(){
        return[
            [['username','password_hash'],'required'],
            ['remember', 'safe']

        ];
    }
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password_hash'=>'密码',
            'remember'=>'记住我',
        ];
    }
}