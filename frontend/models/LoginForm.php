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
    public $password_hash;
    public $remember ;
    public $checkcode ;
//    public $code;
    public function rules(){
        return[
            [['username','password_hash'],'required'],
            ['remember', 'safe']

        ];
    }
    public function login($model)
    {
//        var_dump($model);exit;
        $member=Member::findOne(['username'=>$model->username]);
//                var_dump($model->password);exit;
        if($member!=null){
            if(\yii::$app->security->validatePassword($model->password_hash,$member->password_hash)){
                //记录最后登录时间
                $member->last_login_time=time();
                //记录最后登录ip
                $member->last_login_ip=\Yii::$app->request->userIp;
                //判断是否自动登录
                \yii::$app->user->login($member,$model->remember?3600*24*60:0);
                return $member->save();
            }else{
                \Yii::$app->session->setFlash('success','密码错误');
                return false;
            }
        }else{
            \Yii::$app->session->setFlash('success','用户名不存在');
        }
    }


}