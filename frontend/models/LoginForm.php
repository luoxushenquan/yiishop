<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/12
 * Time: 13:02
 */
namespace frontend\models;
use yii\base\Model;

class LoginForm extends Model{
    public $username;
    public $password;
    public $remember ;
    public $checkcode ;
//    public $code;
    public function rules(){
        return[
            [['username','password'],'required'],
            ['remember', 'safe']

        ];
    }
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'记住我',
        ];
    }

    public function login($model)
    {
//        var_dump($model);exit;
        $member=Member::findOne(['username'=>$model->username]);
//                var_dump($model->password);exit;
        if($member!=null){
            if(\yii::$app->security->validatePassword($model->password,$member->password)){
                //记录最后登录时间
                $member->last_login_time=time();
                //记录最后登录ip
                $member->last_login_ip=\Yii::$app->request->userIp;
                //判断是否自动登录
                \yii::$app->user->login($member,$model->remember?3600*24*60:0);
                $model  =  $member->save();

                //返回
                return $model;
            }else{
                \Yii::$app->session->setFlash('success','密码错误');
                return false;
            }
        }else{
            \Yii::$app->session->setFlash('success','用户名不存在');
        }
    }


}