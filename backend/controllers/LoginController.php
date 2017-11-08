<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 13:01
 */

namespace backend\controllers;
use backend\models\LoginForm;
use backend\models\User;
use yii\web\Controller;

class LoginController extends Controller{

    public function actionLogin(){

        //1.显示登录表单
        //1.1 实例化表单模型

        $model=new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            //表单提交,接收表单数据
            $model->load($request->post());
//            echo '11';exit;
            if($model->validate()){

                //认证 //验证账号密码是否正确
//                $user=new User();
                $user=User::findOne(['username'=>$model->username]);
//                var_dump($admin);exit;
                if($user){
                    if(\yii::$app->security->validatePassword($model->password_hash,$user->password_hash)){
                        //记录最后登录时间
                        $user->last_login_time=time();
                        //记录最后登录ip
                        $user->last_login_ip=\Yii::$app->request->userIp;
                        $user->save();
                        //判断是否自动登录
//                        var_dump($model->remember);exit;
                        if($model->remember=1){
                            //保存到cookie
                            setcookie("username",$model->username,time()+3600*24*365);
                            setcookie("password_hash",$model->password_hash,time()+3600*24*365);
                    }

                        //提示信息  跳转
                        \yii::$app->user->login($user);
                        \Yii::$app->session->setFlash('success','登录成功');
                        //跳转
                        return $this->redirect(['brand/index']);
                    }else{
                        \Yii::$app->session->setFlash('success','密码错误');
                    }
                }else{
                    \Yii::$app->session->setFlash('success','用户名不存在');
                }
            }
        }
        //1.2 调用视图,显示表单
//        echo '11';exit;
        return $this->render('login',['model'=>$model]);
    }

    //注销
    public function actionLogout() {
        \Yii::$app->user->logout();
        //注销成功跳转到登录页
        echo '注销了';
        return $this->render(['login/login']);
    }
}